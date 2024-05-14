<?php

namespace orion\actions;

class Orion_Cron {
	public static function start(): void {
		add_action( 'admin_init', self::admin_init( ... ) );
		add_action( 'orion_generate_sitemap', self::generate_sitemap( ... ) );
	}

	public static function admin_init(): void {
		if ( ! wp_next_scheduled( 'orion_generate_sitemap' ) ) {
			wp_schedule_event( time(), 'daily', 'orion_generate_sitemap' );
		}
	}

	public static function generate_sitemap(): void {
		$keys = [
			'fisherboy'   => [
				'key'      => 'blt1432e72158396625',
				'token'    => 'csc983f364652b3272f0663b6c',
				'filename' => 'fisherboy',
				'locales'  => [ 'en-us', 'es' ],
				'base_url' => 'https://www.fisherboy.com',
				'entities' => [ 'listing', 'page', 'recipe', 'product' ],
			],
			'highliner'   => [
				'key'      => 'blt3301657580909586',
				'token'    => 'csf081a0a20e6b43f61696bd8a',
				'filename' => 'highliner',
				'locales'  => [ 'en-us', 'fr' ],
				'base_url' => 'https://highliner.com',
				'entities' => [ 'listing', 'page', 'recipe', 'product' ],
			],
			'seacuisine'  => [
				'key'      => 'blt6e75cf78cc0f3bd2',
				'token'    => 'cs14362cec6b7182284a8f7060',
				'filename' => 'seacuisine',
				'locales'  => [ 'en-US', 'en-CA', 'fr' ],
				'base_url' => 'https://www.seacuisine.com',
				'entities' => [ 'listing', 'page', 'recipe', 'product' ],
			],
			'foodservice' => [
				'key'      => 'blt4f0d20e0e71d660d',
				'token'    => 'csf3621f38530315c3b577264e',
				'filename' => 'foodservice',
				'locales'  => [ 'en-US', 'en-CA', 'fr' ],
				'base_url' => 'https://www.highlinerfoodservice.com',
				'entities' => [ 'listing', 'page', 'recipe' ],
			],
		];

		$data         = [];
		foreach ( $keys as $component ) {
			echo "Creating {$component['filename']}.json" . PHP_EOL;
			$locales      = $component['locales'];
			$entity_types = $component['entities'];
			foreach ( $entity_types as $entity_type ) {
				foreach ( $locales as $locale ) {
					$response = wp_remote_get(
						"https://cdn.contentstack.io/v3/content_types/{$entity_type}/entries?" . http_build_query( [
							'environment' => 'production',
							'locale'      => $locale,
						] ),
						[
							'headers' => [
								'api_key'      => $component['key'],
								'access_token' => $component['token']
							]
						]
					);
					if ( wp_remote_retrieve_response_code( $response ) === 200 ) {
						$result = json_decode( wp_remote_retrieve_body( $response ) );
						if ( ! empty( $result->entries ) ) {
							foreach ( $result->entries as $entry ) {
								$data[] = [
									'title'  => $entry->title,
									'url'    => $component['base_url'] . self::_generate_url( $entry, $entity_type ),
									'locale' => $entry->locale,
									'type'   => $entity_type,
									'website' => $component['filename'],
								];
							}
						}
					}
				}
			}
		}
		file_put_contents( ORION_PATH . "sitemap.json", json_encode( $data, JSON_UNESCAPED_SLASHES ) );
	}

	private static function _map_type_with_url_token( string $type = 'page' ): string {
		return [
			'page'    => 'url',
			'product' => 'url_token',
			'recipe'  => 'url_token',
			'listing' => 'url',
		][ $type ];
	}

	private static function _generate_url( $item, $type ) {
		$default_locale = 'en-us';
		$url            = $default_locale === $item->locale ? '' : "/{$item->locale}";
		$url            .= $type === 'product' || $type === 'recipe' ? "/{$type}" : '';
		$url            .= $item->{self::_map_type_with_url_token( $type )};

		return $url;
	}
}