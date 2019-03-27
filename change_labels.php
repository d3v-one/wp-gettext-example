<?php

/*
Copyright (C) 2019 by Michael Koch

Permission to use, copy, modify, and/or distribute this software for
any purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL
WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE
AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL
DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA
OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER
TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
*/


$my_translation_table_en_US['Name'] = ['Name (optional)', '', 'default'];
$my_translation_table_en_US['Email'] = ['Email (optional, not shown)', '', 'default'];
$my_translation_table_en_US['Comment'] = ['Opinion', 'noun', 'default'];

$my_translation_table_de_DE['Name'] = ['Name (Optional)', '', 'default'];
$my_translation_table_de_DE['Email'] = ['Email (Optional, wird nicht angezeigt)', '', 'default'];
$my_translation_table_de_DE['Comment'] = ['Meinung', 'noun', 'default'];

$my_translation_table['en_US'] = $my_translation_table_en_US;
$my_translation_table['de_DE'] = $my_translation_table_de_DE;


add_filter( 'gettext_with_context', 'my_gettext_with_context', 20, 4 );

function my_gettext_with_context( $msgstr, $msgid, $msgctxt, $domain )
{
	global $my_translation_table;

	$locale = apply_filters('theme_locale', determine_locale());

	if (isset($my_translation_table[$locale][$msgid])) {
		if ($my_translation_table[$locale][$msgid][1] == $msgctxt) {
			if ($my_translation_table[$locale][$msgid][2] == $domain) {
				return $my_translation_table[$locale][$msgid][0];
			}
		}
	}

  return $msgstr;
}


add_filter('gettext', 'my_gettext', 20, 3);

function my_gettext($msgstr, $msgid, $domain)
{
	return my_gettext_with_context($msgstr, $msgid, '', $domain);
}


add_filter( 'ngettext', 'my_ngettext', 20, 5 );

function my_ngettext($msgstr, $single, $plural, $number, $domain)
{
	if ($number == 1) {
		return my_gettext_with_context($msgstr, $single, '', $domain);
	} else {
		return my_gettext_with_context($msgstr, $plural, '', $domain);
	}
}


add_filter('ngettext_with_context', 'my_ngettext_with_context', 20, 6);

function my_ngettext_with_context($msgstr, $single, $plural, $number, $msgctxt, $domain)
{
	if ($number == 1) {
		return my_gettext_with_context($msgstr, $single, $msgctxt, $domain);
	} else {
		return my_gettext_with_context($msgstr, $plural, $msgctxt, $domain);
	}
}


