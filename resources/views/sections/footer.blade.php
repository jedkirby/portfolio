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
                <p>&copy; {{ \Carbon\Carbon::now()->year.' '.\Config::get('site.meta.title') }}. All Rights Reserved</p>
                <ul class="footer__links">
                    <li>
                        <a href="{{ route('policy.privacy') }}" title="View our Privacy Policy">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{ route('policy.cookie') }}" title="View our Cookie Policy">Cookie Policy</a>
                    </li>
                </ul>
            </div>


        </div>
    </div>
</footer>
