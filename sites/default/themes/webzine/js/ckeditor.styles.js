/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
if (typeof(CKEDITOR) !== 'undefined') {
    CKEDITOR.addStylesSet('drupal', [
        /* Block Styles */

        // These styles are already available in the "Format" drop-down list, so they are
        // not needed here by default. You may enable them to avoid placing the
        // "Format" drop-down list in the toolbar, maintaining the same features.
        { name: '본문(기본)', element: 'p' },
        { 
            name: '본문(18px)', 
            element: 'p', 
            attributes: {
            'class' : 'big-text'
            } 
        },
        { 
            name: '캡션', 
            element: 'p', 
            attributes: {
            'class' : 'origin'
            } 
        },
        { 
            name: '인용', 
            element: 'p', 
            attributes: {
            'class' : 'indent'
            } 
        },
        { name: '단락', element: 'div' },
        //{ name: '제목1', element: 'h1' },
        { name: '제목2', element: 'h2' },
        { name: '제목3', element: 'h3' },
        { name: '제목4', element: 'h4' },
        { name: '제목5', element: 'h5' },
        //{ name: '제목6', element: 'h6' },
        //             { name : 'Address'			, element : 'address' },

        /*
                    { name : 'Blue Title'		, element : 'h3', styles : { 'color' : 'Blue' } },
                    { name : 'Red Title'		, element : 'h3', styles : { 'color' : 'Red' } },
        */

        /* Inline Styles */

        // These are core styles available as toolbar buttons. You may opt enabling
        // some of them in the "Styles" drop-down list, removing them from the toolbar.
        //{ name: 'Strong', element: 'strong', overrides: 'b' },
        //{ name: 'em', element: 'em', overrides: 'i' },
        //{ name: 'u', element: 'u' },
        { name: '취소선', element: 'strike' },
        { name: '아래첨자', element: 'sub' },
        { name: '위첨자', element: 'sup' },

        /*
                    { name : 'Marker: Yellow'	, element : 'span', styles : { 'background-color' : 'Yellow' } },
                    { name : 'Marker: Green'	, element : 'span', styles : { 'background-color' : 'Lime' } },
        */

        /*
                    { name : 'Big'				, element : 'big' },
                    { name : 'Small'			, element : 'small' },
                    { name : 'Typewriter'		, element : 'tt' },

                    { name : 'Computer Code'	, element : 'code' },
                    { name : 'Keyboard Phrase'	, element : 'kbd' },
                    { name : 'Sample Text'		, element : 'samp' },
                    { name : 'Variable'			, element : 'var' },

                    { name : 'Deleted Text'		, element : 'del' },
                    { name : 'Inserted Text'	, element : 'ins' },

                    { name : 'Cited Work'		, element : 'cite' },
                    { name : 'Inline Quotation'	, element : 'q' },

                    { name : 'Language: RTL'	, element : 'span', attributes : { 'dir' : 'rtl' } },
                    { name : 'Language: LTR'	, element : 'span', attributes : { 'dir' : 'ltr' } },
        */

        /* Object Styles */

        {
            name: '테두리 상자',
            element: 'div',
            attributes: {
                'class': 'box'
            }
        },

        {
            name: '배경미색 상자',
            element: 'div',
            attributes: {
                'class': 'box02'
            }
        },

        /*
        {
            name: 'div.box03',
            element: 'div',
            attributes: {
                'class': 'box03'
            }
        },

        {
            name: 'a.btn02',
            element: 'a',
            attributes: {
                'class': 'btn02'
            }
        },

        {
            name: 'a.btn03',
            element: 'a',
            attributes: {
                'class': 'btn03'
            }
        },

        {
            name: 'a.btn04',
            element: 'a',
            attributes: {
                'class': 'btn04'
            }
        },

        {
            name: 'a.btn06',
            element: 'a',
            attributes: {
                'class': 'btn06'
            }
        },

        {
            name: 'Image on Left',
            element: 'img',
            attributes: {
                'style': 'padding: 5px; margin-right: 5px',
                'border': '2',
                'align': 'left'
            }
        },

        {
            name: 'Image on Right',
            element: 'img',
            attributes: {
                'style': 'padding: 5px; margin-left: 5px',
                'border': '2',
                'align': 'right'
            }
        }

        */
    ]);
}