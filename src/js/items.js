( function( $ ) {
	var container = $( '.wp-block-sc-raffle-block' )

	var input = container.find( '.wp-block-sc-raffle-block__input' )
	var add = container.find( '.wp-block-sc-raffle-block__add-new' )
	var remove = container.find( '.wp-block-sc-raffle-block__remove-item' )

	var holder = container.find( '.wp-block-sc-raffle-block__holder' )
	var item = container.find( '.wp-block-sc-raffle-block__item' )
	var defaultItem = container.find( '.wp-block-sc-raffle-block__item-default' )

	add.on( 'click', function( e ) {
		var newItem = $( '<div />', {
			class: 'wp-block-sc-raffle-block__item',
			html: ( input.val() ? input.val() : 'New Item' )
		} ).append( $( '<button />', {
			class: 'wp-block-sc-raffle-block__button wp-block-sc-raffle-block__remove-item',
			html: '<span class="wp-block-sc-raffle-block__button-text">Remove Item</span>'
		} ) )

		e.preventDefault()

		if ( holder.find( defaultItem ) ) {
			defaultItem.remove()
		}

		holder.append( newItem )
		input.val( '' )
	} )

	holder.on( 'click', remove, function( e ) {
		var $this = $( e.target )

		e.preventDefault()

		if ( $this.parent( item ) ) {
			$this.parent( item ).remove()
		}

		if ( ! holder.children().length ) {
			holder.append( defaultItem )
		}
	} )
} )( jQuery )
