<?php declare ( strict_types = 1 );

function get_include_contents( string $path, ?array $vars = [] ): string {
	extract( $vars, EXTR_SKIP );
	ob_start();
	require $path;
	return ob_get_clean();
}

function esc_html( string $text ): string {
	return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8', false );
}

function create_temp_file( string $dir, string $prefix, string $suffix, ?string $contents = '' ): string {
	$tempfile = tempnam( $dir, $prefix );
	rename( $tempfile, $tempfile . $suffix );
	$tempfile = $tempfile . $suffix;
	file_put_contents( $tempfile, $contents );
	return $tempfile;
}

function tidy_html( string $html ): string {
	if ( `command -v npx` ) {
		try {
			$tempfile = create_temp_file( __DIR__, 'tidy_html_temp_', '.html', $html );

			$output = [];
			$return = null;
		
			exec( implode( ' ', [
				'npx',
				'prettier',
				'--use-tabs',
				'--print-width 9999',
				'--html-whitespace-sensitivity strict',
				escapeshellarg( $tempfile ),
			] ), $output, $return );
		
			return implode( "\n", $output );

		} catch ( \Throwable $e ) {
			var_dump( $e );
			return $html;
		} finally {
			if ( file_exists( $tempfile ) ) {
				unlink( $tempfile );
			}
		}
	} else if ( extension_loaded( 'tidy' ) ) {
		$tidy = new tidy();
		$tidy->parseString( $html, [
			'indent'              => true,
			'wrap'                => false,
			'drop-empty-elements' => false,
			'indent-spaces'       => 2,
			'show-body-only'      => true,
		], 'utf8' );
		$tidy->cleanRepair();
		return (string) $tidy;
	} else {
		return $html;
	}
}
