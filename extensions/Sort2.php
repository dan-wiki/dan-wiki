<?php

/**
 * Parser hook extension adds a <sort2> tag to wiki markup
 *
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author kaeptn00 <kaeptn00@yahoo.de>
 * @copyright © 2006 kaeptn00
 * @license GNU General Public Licence 2.0
 * @version 1.1 06/08/24
 *
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgExtensionFunctions[] = 'Sort2';
	$wgExtensionCredits['parserhook'][] = array( 
        'name' => 'Sort2',
        'author' => 'kaeptn00',
        'description' => 'Adds a <tt>&lt;sort2&gt;</tt> tag for sorting lists',
        'url' => 'http://www.mediawiki.org/wiki/Extension:Sort2'
        );

	$wgSort2AllowStyles = true; // Set global config variable to true
	
	
	function Sort2() {
		global $wgParser;
		$wgParser->setHook( 'sort2', 'RenderSort2' );
	}
	
	function RenderSort2( $input, $args, $parser ) {
		$sorter2 = new Sorter2( $parser );
		$sorter2->loadSettings( $args );
		return $sorter2->sortToHtml( $input );
	}
	
	class Sorter2 {
	
		var $parser;
		var $order;
		var $type;
		var $separator;
		var $casesense;
		var $style;
		var $start;
		var $title;
		var $allowStyles;
		
		function Sorter2( &$parser ) {
			$this->parser = &$parser;
			$this->order = 'asc';
			$this->type = 'ul';
			$this->separator = "\n";
			$this->casesense = "false";
			$this->style = "";
			$this->start = "";
			$this->title = "";
			$this->allowStyles = $GLOBALS['wgSort2AllowStyles'];
		}
		
		function loadSettings( $settings ) {
			if( isset( $settings['order'] ) ){
				$o = strtolower( $settings['order'] );
				if( $o == 'asc' || $o == 'desc' || $o == 'none')
					$this->order = $o;
			}
			if( isset( $settings['type'] ) ) {
				$c = strtolower( $settings['type'] );
				if( $c == 'ol' || $c == 'ul' || $c == 'dl' || $c == 'inline' || $c == "br")
					$this->type = $c;
			}
			if( isset($settings['separator']) AND $this->type == "inline" ){
				$this->separator = str_ireplace("&sp;"," ",$settings['separator']);
			}
			if( isset($settings['casesense']) AND strtolower($settings['casesense'] == "true") )
				$this->casesense = "true";
			if( isset($settings['style']) AND $this->allowStyles == true)
				$this->style = 'style="'.$settings['style'].'"';
			if( isset($settings['start']))
				$this->start = 'start="'.$settings['start'].'"';
			if( isset($settings['title']))
				$this->title = str_ireplace("&sp;"," ",$settings['title']);
		}
		
		function sortToHtml( $text ) {
			wfProfileIn( 'Sorter2::sortToHtml' );
			$lines = $this->internalSort( $text );
			$list = $this->makeList( $lines );
			$html = $this->parse( $list );
			wfProfileOut( 'Sorter2::sortToHtml' );
			return $html;
		}
		
		function internalSort( $text ) {
			wfProfileIn( 'Sorter2::internalSort' );
			$lines = explode( "\n", $text );
			$inter = array();
			foreach( $lines as $line )
				$inter[ $line ] = $this->stripWikiTokens( $line );
			
			if ($this->order != "none"){
				if ($this->casesense == "true"){
					natsort( $inter );
				} else {
					natcasesort( $inter );
				}
				
			}
			
			if( $this->order == 'desc' )
				$inter = array_reverse( $inter, true );
			wfProfileOut( 'Sorter2::internalSort' );
			return array_keys( $inter );
		}
		
		function stripWikiTokens( $text ) {
			$find = array( '[', '{', '\'', '}', ']');
			return trim(str_replace( $find, '', $text ));
		}
		
		function stripWikiListTokens( $text ) {
			$find = array( '*', '#',':');
			return trim(str_replace( $find, '', $text ));
		}
		
		function makeList( $lines ) {
			wfProfileIn( 'Sorter2::makeList' );
			$list = array();
			$listtoken = "<li>";
			$endlisttoken = "</li>";

			switch ($this->type){
				case ("ul"):
					$starttoken = "<ul $this->style>";
					$endtoken = "</ul>";
					break;
				case ("ol"):
					$starttoken = "<ol {$this->style} {$this->start}>";
					$endtoken = "</ol>";
					break;
				case ("dl"):
					$starttoken = "<dl $this->style>";
					$endtoken = "</dl>";
					$listtoken = "<dd>";
					$endlisttoken = "";
					break;
				case ("br"):
					$starttoken = "";
					$endtoken = "";
					$listtoken = "";
					$endlisttoken = "";
					$this->separator = "<br />";
					break;
				case ("inline"):
					$starttoken = "";
					$endtoken = "";
					$listtoken = "";
					$endlisttoken = "";
					break;
				default:
					$starttoken = "<ul $this->style>";
					$endtoken = "</ul>";
					break;
			}
			
			
			foreach( $lines as $line )
				if( strlen( $line ) > 0 )
					$list[] = "$listtoken" . $this->stripWikiListTokens($line) . "$endlisttoken";
			wfProfileOut( 'Sorter2::makeList' );
			
			if ($this->type =="ul" OR $this->type=="ol" OR $this->type=="dl"){
				array_unshift($list,$starttoken);
				array_push($list,$endtoken);
			}
			/*array_unshift($list,$this->title);*/
			return $this->title.implode($this->separator, $list );
		}
		
		function parse( $text ) {
			wfProfileIn( 'Sorter2::parse' );
			$title =& $this->parser->mTitle;
			$options =& $this->parser->mOptions;
			$output = $this->parser->parse( $text, $title, $options, true, false );
			wfProfileOut( 'Sorter2::parse' );
			return $output->getText();
		}
		
	}

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( -1 );
}