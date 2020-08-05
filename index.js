import { registerBlockType } from '@wordpress/blocks'

registerBlockType( 'sc/raffle-block', {
	'title': 'Raffle Block',
	'category': 'common',
	'icon': 'randomize',
	'example': {
		attributes: {
			title: 'Wheel of Decisions'
		}
	},
	'attributes': {
		'title': {
			'type': 'string',
			'default': 'Wheel of Decisions'
		}
	},
	'edit': ( props ) => {
		return (
			<p>Raffle Block &mdash; Editor</p>
		)
	}
} )
