<?php

namespace MediaWiki\Extension\NetworkLink;

use Parser;
use PPFrame;
use MediaWiki\MediaWikiServices;

class NetworkLink {

    /**
     * Register the <link> tag during the parser setup
     */
    public static function onParserFirstCallInit( Parser $parser ) {
        // Register the tag hook for <link>
        $parser->setHook( 'link', [ __CLASS__, 'renderNetworkLink' ] );
    }

    /**
     * Callback function to handle <link> tag
     *
     * @param string $input Content inside the <link> tag
     * @param array $args Arguments passed to the tag
     * @param Parser $parser The parser object
     * @param PPFrame $frame The parser frame
     * @return string Rendered HTML link
     */
    public static function renderNetworkLink( $input, array $args, Parser $parser, PPFrame $frame ) {
        // Extract the 'path' argument if present, otherwise use the input text
        $path = isset( $args['path'] ) ? $args['path'] : $input;

        // Sanitize the file path to prevent any security issues
        $sanitizedPath = htmlspecialchars( $path, ENT_QUOTES, 'UTF-8' );

        // Use the 'title' argument if present, otherwise default to the link path
        $linkTitle = isset( $args['title'] ) ? htmlentities( $args['title'], ENT_QUOTES, 'UTF-8' ) : $input;

        // Set the target behavior (default to "_blank")
        $target = isset( $args['target'] ) ? strtoupper( $args['target'] ) : 'BLANK';
        switch ( $target ) {
            case "SELF":
                $targetAttr = "_self";
                break;
            case "TOP":
                $targetAttr = "_top";
                break;
            case "PARENT":
                $targetAttr = "_parent";
                break;
            default:
                $targetAttr = "_blank";
        }

        // Return the HTML link with the appropriate target and title
        return sprintf( '<a href="%1$s" target="%2$s" title="%3$s">%3$s</a>', $sanitizedPath, $targetAttr, $linkTitle );
    }
}
