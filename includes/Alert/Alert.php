<?php

namespace RRZE\Elements\Alert;

defined('ABSPATH') || exit;

/**
 * [Alert description]
 */
class Alert
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        add_shortcode('alert', [$this, 'shortcodeAlert']);
        add_shortcode('inner_alert', [$this, 'shortcodeAlert']);
    }

    /**
     * [shortcodeAlert description]
     * @param  array $atts    [description]
     * @param  string $content [description]
     * @return string          [description]
     */
    public function shortcodeAlert($atts, $content = '')
    {
        extract(shortcode_atts([
            'style' => '',
            'color' => '',
            'border_color' => '',
            'font' => 'dark',
            'title' => '',
        ], $atts));

        $style = (in_array($style, array('success', 'info', 'warning', 'danger', 'example'))) ? ' alert-' . $style : '';
        $font = ($font == 'light') ? ' light' : '';
        $color = ((substr($color, 0, 1) == '#') && (in_array(strlen($color), [4, 7]))) ? 'background-color:' . $color . ';' : '';
        $border_color = ((substr($border_color, 0, 1) == '#') && (in_array(strlen($border_color), [4, 7]))) ? ' border:1px solid' . $border_color . ';' : '';
		$isExample = str_contains($style, 'example');
		$titleTag = '';

        if ('' != $color || '' != $border_color || '' != $font) {
            $style = '';
        }

	    $output = '';
		if ($isExample) {
			if ($title != '') {
				$titleTag = ' title="' . esc_attr($title) . '"';
			}
			$output .= '<div style="overflow: hidden;">';
		}
		$output .= '<div class="alert clearfix clear' . $style . $font . '" style="' . $color . $border_color . '" ' . $titleTag . '>' . do_shortcode(($content)) . '</div>';
	    if ($isExample) {
		    $output .= '</div>';
		}

        wp_enqueue_style('fontawesome');
        wp_enqueue_style('rrze-elements');

        return $output;
    }
}
