import { Component } from '@wordpress/element'
import { InspectorControls } from '@wordpress/block-editor'
import { PanelBody, ToggleControl } from '@wordpress/components'
import classnames from 'classnames'

class Edit extends Component {
	constructor() {
		super( ...arguments )

		this.toggleCheatMode = this.toggleCheatMode.bind( this )
	}

	toggleCheatMode() {
		const { attributes, setAttributes } = this.props
		const { cheat } = attributes

		setAttributes( { cheat: ! cheat } )
	}

	render() {
		const { attributes, setAttributes, className } = this.props
		const { title, cheat } = attributes
		const isCheat = !! cheat

		return [
			( 'undefined' !== typeof scRaffleDebug &&
				<InspectorControls>
					<PanelBody
						title='Cheat Mode'
					>
						<ToggleControl
							label='Activate Cheat Mode?'
							help='Cheat Mode means that the results will be biased towards the first item in the list'
							checked={ cheat }
							onChange={ this.toggleCheatMode }
						/>
					</PanelBody>
				</InspectorControls>
			),
			<div
				className={ classnames( [ className, ...( isCheat ? [ 'is-cheat-mode' ] : [] ) ] ) }
			>
				<h2 className={ classnames( `${className}__title` ) }>{ title }</h2>
				{ isCheat && <p className={ classnames( `${className}__indicator` ) }>Cheat!</p> }
			</div>
		]
	}
}

export default Edit
