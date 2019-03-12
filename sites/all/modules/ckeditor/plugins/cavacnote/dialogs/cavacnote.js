CKEDITOR.dialog.add( 'cavacNoteDialog', function( editor ) {
    return {
        title: 'Cavac Note',
        minWidth: 400,
        minHeight: 200,

        contents: [
            {
                id: 'tab-basic',
                label: 'Basic Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'visibletext',
                        label: 'Visible text',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Visible text field cannot be empty." ),
                        setup: function( element ) {
                            this.setValue( element.getText() );
                        },
                        commit: function( element ) {
                            element.setText( this.getValue() );
                        }
                    },
                    {
                        type: 'text',
                        id: 'popuptitle',
                        label: 'Popup title',
                        //validate: CKEDITOR.dialog.validate.notEmpty( "Popup title field cannot be empty." ),
                        setup: function( element ) {
                            this.setValue( element.getAttribute( "popuptitle" ) );
                        },

                        commit: function( element ) {
                            element.setAttribute( "popuptitle", this.getValue() );
                        }
                    },
                    {
                        type: 'textarea',
                        id: 'popuptext',
                        label: 'Popup text',
                        validate: CKEDITOR.dialog.validate.notEmpty( "Popup text field cannot be empty." ),
                        setup: function( element ) {
                            var popuptext = element.getAttribute( "popuptext" );
                            popuptext = popuptext.replace(/#BR#/gm,"\r\n");
                            popuptext = popuptext.replace(/&quot;/gm,"\"");
                            popuptext = popuptext.replace(/&#39;/gm,"'");
                            this.setValue( popuptext );
                        },

                        commit: function( element ) {
                            var popuptext = this.getValue();
                            popuptext = popuptext.replace(/(\r\n|\n|\r)/gm,"#BR#");
                            popuptext = popuptext.replace(/"/gm,"&quot;");
                            popuptext = popuptext.replace(/'/gm,"&#39;");
                                                                           // angle brackets are replaced completly
                            popuptext = popuptext.replace(/</gm,"&#xab;"); // Force double less-than sign
                            popuptext = popuptext.replace(/>/gm,"&#xbb;"); // Force double greater-than sign
                            element.setAttribute( "popuptext",  popuptext);
                        }
                    }
                ]
            }
        ],
        onShow: function() {
            var selection = editor.getSelection();
            var element = selection.getStartElement();

            if ( element ) {
                element = element.getAscendant( 'span', true );
            }

            if ( !element || element.getName() != 'span' ) {
                element = editor.document.createElement( 'span' );
                element.setAttribute('class', 'cavacnote');
                this.insertMode = true;
            } else {
                this.insertMode = false;
            }

            this.element = element;
            if ( !this.insertMode ) {
                this.setupContent( this.element );
            } else {
                var selectedText = selection.getSelectedText();
                this.setValueOf('tab-basic', 'visibletext', selectedText);
            }
        },
        onOk: function() {
            var dialog = this;
            
            var dialog = this;
            var span = this.element;
            this.commitContent( span );

            if ( this.insertMode ) {
                /*
                var selection = editor.getSelection();
                var selectedText = selection.getSelectedText();
                if(selectedText.length != 0) {
                    selection.getSelectedText().setData('');
                }
                */
                editor.insertElement( span );
            }
        }
    };
});