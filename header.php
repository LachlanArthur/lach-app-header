<header id="lach-app-header">
	<nav>
		<div id="lach-app-header-logo" tabindex="0" role="button">
			<?= file_get_contents( __DIR__ . '/logo.svg' ) ?>
			Lachlan’s Apps
		</div>
		<ul aria-labelledby="lach-app-header-logo">
			<?php foreach ( $apps as ['name' => $name, 'url' => $url] ) { ?>
				<li>
					<a href="<?= esc_html( $url ) ?>"><?= esc_html( $name ) ?></a>
				</li>
			<?php } ?>
		</ul>
	</nav>
</header>
