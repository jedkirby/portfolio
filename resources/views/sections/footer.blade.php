<footer class="footer">
	<div class="site__full">
		<div class="col--wrapper">


			<div class="col  col--6  footer__social">
				<ul>
					@foreach(\Config::get('site.social.visible', []) as $stream)
						<li>
							<a href="{{ \Config::get('site.social.streams.'.$stream.'.url') }}" title="View my {{ \Config::get('site.social.streams.'.$stream.'.title') }}" target="_blank">
								<i class="{{ \Config::get('site.social.streams.'.$stream.'.icon') }}"></i>
							</a>
						</li>
					@endforeach
				</ul>
			</div>


			<div class="col  col--6  footer__copyright">
				<p>Copyright &copy; {{ \Carbon\Carbon::now()->year.' '.\Config::get('site.meta.title') }}. All Rights Reserved.</p>
			</div>


		</div>
	</div>
</footer>
