import { registerBlockType } from '@wordpress/blocks'
import edit from './src/js/edit.js'

registerBlockType( 'sc/raffle-block', {
	'title': 'Raffle Block',
	'category': 'common',
	'icon': 'randomize',
	'attributes': {
		'title': {
			'type': 'string',
			'default': 'Wheel of Decisions'
		},
		'cheat': {
			'type': 'boolean',
			'default': false
		}
	},
	edit
} )
