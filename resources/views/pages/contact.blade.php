@extends('master')
@section('content')

	<div class="site__medium">
		<div class="col--wrapper">


			<div class="col  col--12">
				<div class="col--content">

					@if(!$complete)

						{!! \Form::open(['url' => 'contact', 'class' => 'form', 'novalidate' => 'novalidate']) !!}

							<div class="form__intro">
								<h2>Lets talk!</h2>
								<p>
									If you have a specific requirement that you'd like to talk about, 
									simply fill in this form as fully as possible and I will personally 
									get back to you. Having worked with clients in a number of different 
									time zones, I've given up on using the phone. However, you can reach 
									me through e-mail {!! Html::mailto(Config::get('site.meta.email.to')) !!}
								</p>
							</div>

							<div class="form__wrap form__wrap--poof">
								{!!
									Form::text(
										'title',
										\Input::old('title'),
										[
											'class' => 'form__field',
											'placeholder' => 'Title'
										]
									)
								!!}
							</div>

							<div class="form__wrap  {{ ($errors->first('name')) ? 'form__wrap--error' : '' }}">
								{!!
									Form::text(
										'name',
										\Input::old('name'),
										[
											'class' => 'form__field',
											'placeholder' => 'Name',
											'autofocus' => 'autofocus'
										]
									)
								!!}
								<span class="form__error">{{ $errors->first('name') }}</span>
							</div>

							<div class="form__wrap  {{ ($errors->first('email')) ? 'form__wrap--error' : '' }}">
								{!!
									Form::email(
										'email',
										\Input::old('email'),
										[
											'class' => 'form__field',
											'placeholder' => 'Email'
										]
									)
								!!}
								<span class="form__error">{{ $errors->first('email') }}</span>
							</div>

							<div class="form__wrap  {{ ($errors->first('subject')) ? 'form__wrap--error' : '' }}">
								{!!
									Form::text(
										'subject',
										\Input::old('subject', $subject),
										[
											'class' => 'form__field',
											'placeholder' => 'Subject'
										]
									)
								!!}
								<span class="form__error">{{ $errors->first('subject') }}</span>
							</div>

							<div class="form__wrap  {{ ($errors->first('content')) ? '  form__wrap--error' : '' }}">
								{!!
									Form::textarea(
										'content',
										\Input::old('content'),
										[
											'class' => 'form__field  form__field--resize-vertical',
											'placeholder' => 'Brief Project Description'
										]
									)
								!!}
								<span class="form__error">{{ $errors->first('content') }}</span>
							</div>

							<div class="form__control">
								<button type="submit" class="form__button  btn  btn__primary">Start the conversation...</button>
							</div>

						{!! \Form::close() !!}

					@else

						<div class="contact__complete">
							<i class="fa fa-paper-plane-o"></i>
							<h1>Thanks for your question!</h1>
							<p>I'll get back to you as soon as possible</p>
						</div>

					@endif

				</div>
			</div>


		</div>
	</div>

@stop
