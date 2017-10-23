<html lang="ru">
<head>
    <meta charset="text/html">
    <style>
        p {
            color: #AFB2B3;
            margin: 0;
        }
        ul {
            list-style-type: none;
            padding-left: 10px;
        }
        li {
            margin-bottom: 5px;
        }
        li span+span {
            color: #262626;
        }
        .left-span {
            width: 170px;
            color: #898989;
            display: inline-block;
        }
    </style>
</head>
<body>
@if($clientRequest->type == 1)
    <h1>{{ $layout->residentialComplex->title }}</h1>
    <p>{{ $layout->residentialComplex->developer->name }}</p>
    <ul>
        <li>Кол-во комнат: <span>{{ $layout->getRoomLabel('full') }}</span></li>
        <li>Площадь: <span>{{ $layout->area }}</span></li>
        <li>Планировка: <a href="{{ $layout->main_image_original }}" target="_blank">Посмотреть</a></li>
        <li>Этажи: <span>{{ $layout->calculateFloorRangeFromApartments('full') }}</span></li>
        <li>Срок сдачи: <span>{{ $layout->apartments->first()->house->getQuarterLabel('full') }} {{ $layout->apartments->first()->house->completion_year }}</span></li>
        <li>Цена за м<sup>2</sup>: <span>{{ $layout->getPriceMeterRange() }} руб.</span></li>
        <li>Стоимость квартиры: <span>{{ $layout->getPriceRange() }} руб.</span></li>
    </ul>
@elseif($clientRequest->type == 2)
    <h1>Заявка на ипотеку</h1>
@elseif($clientRequest->type == 3)
    <h1>Форма обратной связи</h1>
    <ul>
        <li>{{ $clientRequest->client_name }}</li>
        <li>{{ $clientRequest->comment }}</li>
    </ul>
@endif
<h2>{{ $clientRequest->getFormattedClientPhone() }}</h2>
</body>
</html>