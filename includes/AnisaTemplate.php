<?php
/**
 * BaseTemplate class for the Anisa skin
 *
 * @ingroup Skins
 */
class AnisaTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$html = '';

		$html .= Html::rawElement( 'div', [ 'id' => 'mw-wrapper' ],
			Html::rawElement( 'div', [ 'id' => 'column-content' ],
				Html::rawElement( 'div', [ 'id' => 'header' ],
					$this->getBanner() .
					$this->getUserLinks() .
					$this->getSearch() .
					$this->getClear()
				) .
				Html::rawElement( 'div', [ 'id' => 'content-container-container' ],
				Html::rawElement( 'div', [ 'id' => 'content-container' ],
				Html::rawElement( 'div', [ 'id' => 'content' ],
					// Page editing and tools
					Html::rawElement(
						'div',
						[ 'id' => 'page-tools' ],
						$this->getPageLinks()
					) .
					Html::rawElement( 'div', [ 'class' => 'mw-body', 'role' => 'main' ],
						$this->getSiteNotice() .
						$this->getNewTalk() .
						$this->getIndicators() .
						Html::rawElement( 'div', [ 'id' => 'firstHeading-container' ],
							Html::rawElement( 'h1',
								[
									'class' => 'firstHeading',
									'lang' => $this->get( 'pageLanguage' )
								],
								$this->get( 'title' )
							)
						) .
						Html::rawElement( 'div', [ 'id' => 'siteSub' ],
							$this->getMsg( 'tagline' )->parse()
						) .
						Html::rawElement( 'div', [ 'class' => 'mw-body-content' ],
							Html::rawElement( 'div', [ 'id' => 'contentSub' ],
								$this->getPageSubtitle() .
								Html::rawElement(
									'p',
									[],
									$this->get( 'undelete' )
								)
							) .
							$this->get( 'bodycontent' ) .
							$this->getClear() .
							Html::rawElement( 'div', [ 'class' => 'printfooter' ],
								$this->get( 'printfooter' )
							) .
							$this->getCategoryLinks() .
							$this->getDataAfterContent() .
							$this->get( 'debughtml' )
						)
					)
				) .
				Html::element( 'div', [ 'id' => 'lright1', 'class' => 'right-line' ] ) .
				Html::element( 'div', [ 'id' => 'lright2', 'class' => 'right-line' ] ) .
				Html::element( 'div', [ 'id' => 'lright3', 'class' => 'right-line' ] )
				) .
				Html::rawElement( 'div', [ 'id' => 'content-footer-container' ],
					Html::rawElement( 'div', [ 'id' => 'content-footer' ],
						$this->getMsg( 'content-footer' )->parse() .
						$this->getClear()
					)
				) ) .
				$this->getFooterBlock()
			) .
			Html::rawElement( 'div', [ 'id' => 'column-navigation' ],
				Html::rawElement( 'div', [ 'id' => 'mw-navigation' ],
					Html::rawElement(
						'h2',
						[],
						$this->getMsg( 'navigation-heading' )->parse()
					) .
					$this->getLogo() .
					// Site navigation/sidebar
					Html::rawElement(
						'div',
						[ 'id' => 'site-navigation' ],
						$this->getSiteNavigation()
					)
				)
			)
		);

		echo $html;
	}

	/**
	 * Generates siteNotice, if any
	 * @return string html
	 */
	protected function getSiteNotice() {
		return $this->getIfExists( 'sitenotice', [
			'wrapper' => 'div',
			'parameters' => [ 'id' => 'siteNotice' ]
		] );
	}

	/**
	 * Generates new talk message banner, if any
	 * @return string html
	 */
	protected function getNewTalk() {
		return $this->getIfExists( 'newtalk', [
			'wrapper' => 'div',
			'parameters' => [ 'class' => 'usermessage' ]
		] );
	}

	/**
	 * Generates subtitle stuff, if any
	 * @return string html
	 */
	protected function getPageSubtitle() {
		return $this->getIfExists( 'subtitle', [ 'wrapper' => 'p' ] );
	}

	/**
	 * Generates category links, if any
	 * @return string html
	 */
	protected function getCategoryLinks() {
		return $this->getIfExists( 'catlinks' );
	}

	/**
	 * Generates data after content stuff, if any
	 * @return string html
	 */
	protected function getDataAfterContent() {
		return $this->getIfExists( 'dataAfterContent' );
	}

	/**
	 * Generates the logo and (optionally) site title
	 * @param string $id
	 * @return string html
	 */
	protected function getLogo( $id = 'p-logo' ) {
		$html = Html::openElement(
			'div',
			[
				'id' => $id,
				'class' => 'mw-portlet',
				'role' => 'banner'
			]
		);
		$html .= Html::element(
			'a',
			[
				'href' => $this->data['nav_urls']['mainpage']['href'],
				'class' => 'mw-wiki-logo',
			] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' )
		);
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Generate the banner at the top of the file
	 * @param string $id
	 * @return string html
	 */
	protected function getBanner( $id = 'p-banner' ) {
		$language = $this->getSkin()->getLanguage();
		$siteTitle = $language->convert( $this->getMsg( 'sitetitle' )->escaped() );

		$html = Html::rawElement(
			'a',
			[
				'id' => $id,
				'class' => 'mw-wiki-title',
				'href' => $this->data['nav_urls']['mainpage']['href']
			] + Linker::tooltipAndAccesskeyAttribs( 'p-logo' ),
			$siteTitle
		);

		return $html;
	}

	/**
	 * Generates the search form
	 * @return string html
	 */
	protected function getSearch() {
		$html = Html::openElement(
			'form',
			[
				'action' => $this->get( 'wgScript' ),
				'role' => 'search',
				'class' => 'mw-portlet',
				'id' => 'p-search'
			]
		);
		$html .= Html::hidden( 'title', $this->get( 'searchtitle' ) );
		$html .= Html::rawElement(
			'h3',
			[],
			Html::label( $this->getMsg( 'search' )->text(), 'searchInput' )
		);
		$html .= $this->makeSearchInput( [ 'id' => 'searchInput' ] );
		$html .= $this->makeSearchButton( 'go', [
			'id' => 'searchGoButton',
			'class' => 'searchButton',
			'value' => $this->getMsg( 'searcharticle' )->text()
		] );
		$html .= Html::closeElement( 'form' );

		return $html;
	}

	/**
	 * Generates the sidebar
	 * Set the elements to true to allow them to be part of the sidebar
	 * Or get rid of this entirely, and take the specific bits to use wherever you actually want them
	 *  * Toolbox is the page/site tools that appears under the sidebar in vector
	 *  * Languages is the interlanguage links on the page via en:... es:... etc
	 *  * Default is each user-specified box as defined on MediaWiki:Sidebar; you will still need a foreach loop
	 *    to parse these.
	 * @return string html
	 */
	protected function getSiteNavigation() {
		$html = '';

		$sidebar = $this->getSidebar();
		$sidebar['SEARCH'] = false;
		$sidebar['TOOLBOX'] = true;
		$sidebar['LANGUAGES'] = true;

		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					$html .= $this->getSearch();
					break;
				case 'TOOLBOX':
					$html .= $this->getPortlet( 'tb', $this->data['sidebar']['TOOLBOX'], 'toolbox' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] !== false ) {
						$html .= $this->getPortlet( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$html .= $this->getPortlet( $name, $content['content'] );
					break;
			}
		}
		return $html;
	}

	/**
	 * Generates page-related tools/links
	 * You will probably want to split this up and move all of these to somewhere that makes sense for your skin.
	 * @return string html
	 */
	protected function getPageLinks() {
		// Namespaces: links for 'content' and 'talk' for namespaces with talkpages. Otherwise is just the content.
		// Usually rendered as tabs on the top of the page.
		$html = $this->getPortlet(
			'namespaces',
			$this->data['content_navigation']['namespaces']
		);
		// Variants: Language variants. Displays list for converting between different scripts in the same language,
		// if using a language where this is applicable.
		if ( $this->data['content_navigation']['variants'] ) {
			$html .= $this->getPortlet(
				'variants',
				$this->data['content_navigation']['variants']
			);
		}
		// Other actions for the page: move, delete, protect, everything else
		if ( $this->data['content_navigation']['actions'] ) {
			$html .= $this->getPortlet(
				'actions',
				$this->data['content_navigation']['actions']
			);
		}
		// 'View' actions for the page: view, edit, view history, etc
		$html .= $this->getPortlet(
			'views',
			$this->data['content_navigation']['views']
		);

		$html .= $this->getClear();

		return $html;
	}

	/**
	 * Personal/user links portlet for header
	 *
	 * @return string HTML
	 */
	protected function getUserLinks() {
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();

		$html = '';
		$extraTools = [];

		// Remove Echo badges
		if ( isset( $personalTools['notifications-alert'] ) ) {
			$extraTools['notifications-alert'] = $personalTools['notifications-alert'];
			unset( $personalTools['notifications-alert'] );
		}
		if ( isset( $personalTools['notifications-notice'] ) ) {
			$extraTools['notifications-notice'] = $personalTools['notifications-notice'];
			unset( $personalTools['notifications-notice'] );
		}
		// Remove ULS trigger
		if ( isset( $personalTools['uls'] ) ) {
			$extraTools['uls'] = $personalTools['uls'];
			unset( $personalTools['uls'] );
		}

		// Re-label some messages
		if ( isset( $personalTools['userpage'] ) ) {
			$personalTools['userpage']['links'][0]['text'] = $this->getMsg( 'anisa-userpage' )->text();
		}
		if ( isset( $personalTools['mytalk'] ) ) {
			$personalTools['mytalk']['links'][0]['text'] = $this->getMsg( 'anisa-talkpage' )->text();
		}

		// Dropdown header
		if ( $user->isRegistered() ) {
			$headerMsg = [ 'anisa-loggedinas', $user->getName() ];
		} else {
			$headerMsg = [ 'anisa-notloggedin', $user->getName() ];
		}
		$html .= Html::openElement( 'div', [ 'id' => 'user-tools' ] );

		// Extra icon/outside stuff (echo etc)
		if ( !empty( $extraTools ) ) {
			$iconList = '';
			foreach ( $extraTools as $key => $item ) {
				$iconList .= $this->makeListItem( $key, $item );
			}

			$html .= Html::rawElement(
				'div',
				[ 'id' => 'p-personal-extra', 'class' => 'p-body' ],
				Html::rawElement( 'ul', [], $iconList )
			);
		}

		$html .= $this->getPortlet( 'personal', $personalTools, $headerMsg );

		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Simple wrapper for random if-statement-wrapped $this->data things
	 *
	 * @param string $object name of thing
	 * @param array $setOptions
	 *
	 * @return string html
	 */
	protected function getIfExists( $object, $setOptions = [] ) {
		$options = $setOptions + [
			'wrapper' => 'none',
			'parameters' => []
		];

		$html = '';

		if ( $this->data[$object] ) {
			// @phan-suppress-next-line PhanSuspiciousValueComparison
			if ( $options['wrapper'] === 'none' ) {
				$html .= $this->get( $object );
			} else {
				$html .= Html::rawElement(
					$options['wrapper'],
					$options['parameters'],
					$this->get( $object )
				);
			}
		}

		return $html;
	}

	/**
	 * Generates a block of navigation links with a header
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 * @param null|string|array $msg
	 * @param array $setOptions random crap to rename/do/whatever
	 *
	 * @return string html
	 */
	protected function getPortlet( $name, $content, $msg = null, $setOptions = [] ) {
		// random stuff to override with any provided options
		$options = $setOptions + [
			// extra classes/ids
			'id' => 'p-' . $name,
			'class' => 'mw-portlet',
			'extra-classes' => '',
			// what to wrap the body list in, if anything
			'body-wrapper' => 'div',
			'body-id' => null,
			'body-class' => 'mw-portlet-body',
			// makeListItem options
			'list-item' => [ 'text-wrapper' => [ 'tag' => 'span' ] ],
			// option to stick arbitrary stuff at the beginning of the ul
			'list-prepend' => ''
		];

		// Handle the different $msg possibilities
		if ( $msg === null ) {
			$msg = $name;
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		}
		$msgObj = $this->getMsg( $msg );
		if ( $msgObj->exists() ) {
			if ( isset( $msgParams ) && !empty( $msgParams ) ) {
				$msgString = $this->getMsg( $msg, $msgParams )->parse();
			} else {
				$msgString = $msgObj->parse();
			}
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul',
				[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ]
			);
			$contentText .= $options['list-prepend'];
			foreach ( $content as $key => $item ) {
				$contentText .= $this->makeListItem( $key, $item, $options['list-item'] );
			}

			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		// Special handling for role=search and other weird things
		$divOptions = [
			'role' => 'navigation',
			'id' => Sanitizer::escapeIdForAttribute( $options['id'] ),
			'title' => Linker::titleAttrib( $options['id'] ),
			'aria-labelledby' => $labelId
		];
		$divOptions['class'] = array_merge( (array)$options['class'], (array)$options['extra-classes'] );

		$labelOptions = [
			'id' => $labelId,
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		];

		// @phan-suppress-next-line PhanSuspiciousValueComparison
		if ( $options['body-wrapper'] !== 'none' ) {
			$bodyDivOptions = [ 'class' => $options['body-class'] ];
			// @phan-suppress-next-line PhanImpossibleCondition
			if ( is_string( $options['body-id'] ) ) {
				$bodyDivOptions['id'] = $options['body-id'];
			}
			$body = Html::rawElement( $options['body-wrapper'], $bodyDivOptions,
				$contentText .
				$this->getSkin()->getAfterPortlet( $name )
			);
		} else {
			$body = $contentText . $this->getSkin()->getAfterPortlet( $name );
		}

		$html = Html::rawElement( 'div', $divOptions,
			Html::rawElement( 'h3', $labelOptions, $msgString ) .
			$body
		);

		return $html;
	}

	/**
	 * Better renderer for the footer icons and getFooterLinks
	 *
	 * @param array $setOptions Miscellaneous other options
	 * * 'id' for footer id
	 * * 'order' to determine whether icons or links appear first: 'iconsfirst' or links, though in
	 *   practice we currently only check if it is or isn't 'iconsfirst'
	 * * 'link-prefix' to set the prefix for all link and block ids; most skins use 'f' or 'footer',
	 *   as in id='f-whatever' vs id='footer-whatever'
	 * * 'link-style' to pass to getFooterLinks: "flat" to disable categorisation of links in a
	 *   nested array
	 *
	 * @return string html
	 */
	protected function getFooterBlock( $setOptions = [] ) {
		// Set options and fill in defaults
		$options = $setOptions + [
			'id' => 'footer',
			'order' => 'iconsfirst',
			'link-prefix' => 'footer',
			'link-style' => null
		];

		$validFooterIcons = $this->get( 'footericons' );
		$validFooterLinks = $this->getFooterLinks( $options['link-style'] );

		$html = '';

		$html .= Html::openElement( 'div', [
			'id' => $options['id'],
			'role' => 'contentinfo',
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		] );

		$iconsHTML = '';
		if ( $validFooterIcons ) {
			$skin = $this->getSkin();
			$iconsHTML .= Html::openElement( 'ul', [ 'id' => "{$options['link-prefix']}-icons" ] );
			foreach ( $validFooterIcons as $blockName => &$footerIcons ) {
				$iconsHTML .= Html::openElement( 'li', [
					'id' => Sanitizer::escapeIdForAttribute(
						"{$options['link-prefix']}-{$blockName}ico"
					),
					'class' => 'footer-icons'
				] );
				foreach ( $footerIcons as $footerIconKey => $icon ) {
					if ( !isset( $icon['src'] ) ) {
						unset( $footerIcons[$footerIconKey] );
					}
					$iconsHTML .= $skin->makeFooterIcon( $icon );
				}
				$iconsHTML .= Html::closeElement( 'li' );
			}
			$iconsHTML .= Html::closeElement( 'ul' );
		}

		$linksHTML = '';
		if ( $validFooterLinks ) {
			// @phan-suppress-next-line PhanSuspiciousValueComparison
			if ( $options['link-style'] === 'flat' ) {
				$linksHTML .= Html::openElement( 'ul', [
					'id' => "{$options['link-prefix']}-list",
					'class' => 'footer-places'
				] );
				foreach ( $validFooterLinks as $link ) {
					$linksHTML .= Html::rawElement(
						'li',
						[ 'id' => Sanitizer::escapeIdForAttribute( $link ) ],
						$this->get( $link )
					);
				}
				$linksHTML .= Html::closeElement( 'ul' );
			} else {
				$linksHTML .= Html::openElement( 'div', [ 'id' => "{$options['link-prefix']}-list" ] );
				foreach ( $validFooterLinks as $category => $links ) {
					$linksHTML .= Html::openElement( 'ul',
						[ 'id' => Sanitizer::escapeIdForAttribute(
							"{$options['link-prefix']}-{$category}"
						) ]
					);
					foreach ( $links as $link ) {
						$linksHTML .= Html::rawElement(
							'li',
							[ 'id' => Sanitizer::escapeIdForAttribute(
								"{$options['link-prefix']}-{$category}-{$link}"
							) ],
							$this->get( $link )
						);
					}
					$linksHTML .= Html::closeElement( 'ul' );
				}
				$linksHTML .= Html::closeElement( 'div' );
			}
		}

		// @phan-suppress-next-line PhanSuspiciousValueComparison
		if ( $options['order'] === 'iconsfirst' ) {
			$html .= $iconsHTML . $linksHTML;
		} else {
			$html .= $linksHTML . $iconsHTML;
		}

		$html .= $this->getClear() . Html::closeElement( 'div' );

		return $html;
	}
}
