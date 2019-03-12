CKEDITOR.plugins.add('cavacnote', {
    icons: 'cavacnote',
    init: function(editor) {
        editor.addCommand('cavacnote', new CKEDITOR.dialogCommand('cavacNoteDialog'), {
            allowedContent: 'span[class,popuptitle,popupmessage],a[href]'
        });
        editor.ui.addButton('cavacnote', {
            label: 'Cavac Note',
            command: 'cavacnote',
            toolbar: 'insert'
        });
        CKEDITOR.dialog.add( 'cavacNoteDialog', this.path + 'dialogs/cavacnote.js' );
        
        // Context menu for editing existing notes
        if(editor.contextMenu) {
            editor.addMenuGroup('cavacGroup');
            editor.addMenuItem('cavacnoteItem', {
                label: "Edit Cavac Note",
                icon: this.path + 'icons/cavacnote.png',
                command: 'cavacnote',
                group: 'cavacGroup'
            });
            
            editor.contextMenu.addListener( function(element) {
                var isCavacNote = (element.is( 'span' ) && (element.hasClass('cavacnote')))
                    || (element.hasAscendant( 'span' ) && element.getAscendant('span').hasClass('cavacnote'));
                if(isCavacNote) {
                    return { cavacnoteItem: CKEDITOR.TRISTATE_OFF};
                }
                
            });
        }
    }
});
