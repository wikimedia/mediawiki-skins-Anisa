<?php
/**
 * SkinTemplate class for the Anisa skin
 *
 * @ingroup Skins
 */
class SkinAnisa extends SkinTemplate {
	public $skinname = 'anisa',
		$stylename = 'Anisa',
		$template = 'AnisaTemplate';

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	public function initPage( OutputPage $out ) {
		$out->addMeta( 'viewport',
			'width=device-width, initial-scale=1.0, ' .
			'user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.anisa'
		] );
		$out->addModules( [
			'skins.anisa.js'
		] );
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}
}
