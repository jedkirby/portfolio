<div class="js-input">

	<h4 class="interest__title">Lets Collaborate?</h4>

	{!! \Form::open(['class' => 'interest__form  js-form', 'novalidate' => 'novalidate']) !!}

		{!! \Form::email('email', \Input::old('email'), ['placeholder' => 'interested@me.com', 'class' => 'interest__field  form__field']) !!}
		{!! \Form::submit('Go', ['class' => 'interest__button  form__button  btn  btn__primary']) !!}

		<div class="js-error"></div>

	{!! \Form::close() !!}

</div>
