import classnames from 'classnames'

function Edit( props ) {
	const { attributes, setAttributes, className } = props
	const { title, cheat } = attributes
	const isCheat = !! cheat

	return (
		<div
			className={ classnames( [ className, ...( isCheat ? [ 'is-cheat-mode' ] : [] ) ] ) }
		>
			<h2 className={ classnames( `${className}__title` ) }>{ title }</h2>
			{ isCheat && <p className={ classnames( `${className}__indicator` ) }>Cheat!</p> }
		</div>
	)
}

export default Edit
