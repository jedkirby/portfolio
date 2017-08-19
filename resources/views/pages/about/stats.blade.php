<div class="stats">

    <div class="site__full">
        <div class="col--wrapper">

            <div class="col  col--3  stats__item">
                <div class="col--content  text-center">
                    <p class="stats__count">{{ array_get($counts, 'tea', 0) }}</p>
                    <p class="stats__type">Cups of Tea</p>
                </div>
            </div>

            <div class="col  col--3  stats__item">
                <div class="col--content  text-center">
                    <p class="stats__count">{{ array_get($counts, 'food', 0) }}</p>
                    <p class="stats__type">Pizzas Ordered</p>
                </div>
            </div>

            <div class="col  col--3  stats__item">
                <div class="col--content  text-center">
                    <p class="stats__count">{{ array_get($counts, 'projects', 0) }}</p>
                    <p class="stats__type">Complete Projects</p>
                </div>
            </div>

            <div class="col  col--3  stats__item">
                <div class="col--content  text-center">
                    <a href="{{ route('articles') }}" title="See my articles">
                        <p class="stats__count">{{ array_get($counts, 'articles', 0) }}</p>
                        <p class="stats__type">Articles Written</p>
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
