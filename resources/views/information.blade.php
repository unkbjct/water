@extends('layouts.main')

@section('main')
    <div class="container my-5">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        <section class="mb-5 mx-auto" style="max-width: 700px" id="mobile">
            <div class="row gy-4 mb-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="mb-4">Мобильное приложение</h2>
                            <p>Смотрите, выбирайте и покупайте в мобильном приложение прямо сейчас!</p>
                            <a href="">
                                <img style="height: 50px; object-fit: scale-down;"
                                    src="{{ asset('public/storage/img/svg/google-play-badge.png') }}" alt="">
                            </a>
                            <a href="">
                                <img style="height: 50px; object-fit: scale-down; object-position: left;"
                                    src="{{ asset('public/storage/img/svg/app-store.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"
                    style="background-image: url({{ asset('public/storage/img/svg/mob_main.png') }}); background-size: contain;
                background-repeat: no-repeat; background-position: center;">
                </div>
            </div>
            <div>
                <h4 class="mb-4 text-center">Вот, что говорят наши пользователи о приложении</h4>
                <div class="card mb-4">
                    <div class="card-body p-0 px-4 pt-3">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <div class="mb-2">Владимир А.</div>
                                    <div class=" fs-5 fw-bold">Приложения проще и привычнее</div>
                                    <div>Не люблю вкладки в мобильном браузере и много покупок делаю именно
                                        через приложения, они удобнее</div>
                                </div>
                            </div>
                            <div class="col-lg-4"
                                style="background-image: url({{ asset('public/storage/img/svg/mob.png') }}); background-size: contain;
                            background-repeat: no-repeat; background-position: right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body p-0 px-4 pt-3">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <div class="mb-2">Егор Г.</div>
                                    <div class=" fs-5 fw-bold">То, что смотрел с компьютера, не потеряется</div>
                                    <div>Смотрю товары в избранном или корзине и с компьютера, и с телефона. Ничего не
                                        теряется</div>
                                </div>
                            </div>
                            <div class="col-lg-4"
                                style="background-image: url({{ asset('public/storage/img/svg/tablet.png') }}); background-size: contain;
                            background-repeat: no-repeat; background-position: right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body p-0 px-4 pt-3">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <div class="mb-2">Екатерина К.</div>
                                    <div class=" fs-5 fw-bold">Легко отслеживать статусы заказов</div>
                                    <div>Не нужно искать сайт — смотрю прямо в приложении</div>
                                </div>
                            </div>
                            <div class="col-lg-4"
                                style="background-image: url({{ asset('public/storage/img/svg/shild.png') }}); background-size: contain;
                            background-repeat: no-repeat; background-position: right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body p-0 px-4 pt-3">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <div class="mb-2">Ярослав Г.</div>
                                    <div class=" fs-5 fw-bold">Удобно при ремонте</div>
                                    <div>Делаю ремонт и много выбираю в любой свободный момент, а приложение всегда под
                                        рукой</div>
                                </div>
                            </div>
                            <div class="col-lg-4"
                                style="background-image: url({{ asset('public/storage/img/svg/vanna.png') }}); background-size: contain;
                            background-repeat: no-repeat; background-position: right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body p-0 px-4 pt-3">
                        <div class="row gy-4">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <div class="mb-2">Мария О.</div>
                                    <div class=" fs-5 fw-bold">Делаю выбор на ходу</div>
                                    <div>По пути на работу накидываю корзину в приложении и вечером предметно изучаю товары
                                        с компьютера</div>
                                </div>
                            </div>
                            <div class="col-lg-4"
                                style="background-image: url({{ asset('public/storage/img/svg/like.png') }}); background-size: contain;
                            background-repeat: no-repeat; background-position: right;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-5" id="shops">
            <h2 class="mb-4">Магазины</h2>
            <div class="container-map">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa1b990664b3ea6b90295802a5b9a257fbf09d5f8bec30cc23e4f32d22b3d64a8&amp;source=constructor"
                    width="100%" height="450" frameborder="0"></iframe>
            </div>
        </section>
        <section class="mb-5" id="contacts">
            <h2 class="mb-4">Контакты</h2>
            <div class="card mb-4">
                <div class="card-bory">
                    <div class="row gy-4">
                        <div class="col-lg-3">
                            <div class="text-center py-3">
                                <div class="bg-primary-subtle rounded-circle mx-auto p-3 mb-3" style="width: fit-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                        fill="currentColor" class="bi bi-headphones" viewBox="0 0 16 16">
                                        <path
                                            d="M8 3a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V8a6 6 0 1 1 12 0v5a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h1V8a5 5 0 0 0-5-5z" />
                                    </svg>
                                </div>
                                <div class="fw-bold mb-2">Контакт-центр</div>
                                <div class="mb-4">Ежедневно с 8:00 до 01:00 (МСК)</div>
                                <a href="">8 (800) 700 15 00</a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center py-3">
                                <div class="bg-primary-subtle rounded-circle mx-auto p-3 mb-3" style="width: fit-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                        fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                    </svg>
                                </div>
                                <div class="fw-bold mb-2">Обратный звонок</div>
                                <div class="mb-4">Оставьте номер и мы вам перезвоним</div>
                                <a href="">Перезвоните мне</a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center py-3">
                                <div class="bg-primary-subtle rounded-circle mx-auto p-3 mb-3" style="width: fit-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                        fill="currentColor" class="bi bi-chat-dots-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                    </svg>
                                </div>
                                <div class="fw-bold mb-2">Мессенджеры</div>
                                <div class="mb-4">Ежедневно с 8:00 до 23:00 (МСК)</div>
                                <a class="me-2" href=""><svg xmlns="http://www.w3.org/2000/svg" width="30"
                                        height="30" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z" />
                                    </svg></a>
                                <a href=""><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                        fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path
                                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                    </svg></a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="text-center py-3">
                                <div class="bg-primary-subtle rounded-circle mx-auto p-3 mb-3" style="width: fit-content">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                        fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                        <path
                                            d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                    </svg>
                                </div>
                                <div class="fw-bold mb-2">Магазины</div>
                                <div class="mb-4">Найдите магазин и придиите туда</div>
                                <a href="#shops">список</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mx-auto" style="max-width: 700px">
                <div class="card-body">
                    <h4 class="mb-3">Обратная связь</h4>
                    <form action="{{ route('feedback.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Электронная почта</label>
                            <input required type="email" name="email" class="form-control" id="email">
                            <div id="emailHelp" class="form-text">На нее будет выслан ответ (если требуется).</div>
                        </div>
                        <div class="mb-3">
                            <label for="point" class="form-label">Причина обращения</label>
                            <input required type="text" name="point" class="form-control" id="point">
                            <div id="pointHelp" class="form-text">Напишите причину обращения чтобы нам было легче понять
                                проблему(Заказ/Профиль/...).</div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea required name="description" id="description" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </section>

    </div>
@endsection
