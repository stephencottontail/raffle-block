import { registerBlockType } from '@wordpress/blocks'

registerBlockType( 'sc/raffle-block', {
	'title': 'Raffle Block',
	'category': 'common',
	'icon': 'randomize',
	'example': {},
	'edit': () => {
		return (
			<p>Raffle Block &mdash; Editor</p>
		)
	}
} )
