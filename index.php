<?php 
require("connectdb.php");
$result = mysqli_query($connect, "SELECT * FROM `parking` WHERE ID = 1");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=divice-width, initial-scale=1.0">
    <title>Parking</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css"> 

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<body>
    <header class="header">
        <nav>
            <div class="title">
                Велопарковки г.Москва
            </div>
        </nav>
    </header>
    
        <div class="sum"></div>
        
       
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "1">Северо-Восточный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "2">Юго-Западный административный округ</a>   
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "3">Юго-Восточный административный округ</a>  
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "4">Центральный административный округ</a> 
        
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "5">Западный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "6">Южный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "7">Восточный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "8">Зеленоградский административный округ</a>
        
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "9">Северный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "10">Северо-Западный административный округ</a>
        <a class="btn btn-secondary" href="#" role="button" name="send" value = "10">Новомосковский административный округ</a>
       

       
        
        <?php 
           $dbh = new PDO('mysql:host=std-mysql.ist.mospolytech.ru;dbname=std_1545_parking', 'std_1545_parking', 'parkingparking');
           $sth = $dbh->prepare("SELECT * FROM `parking` ORDER BY `ID`");
           $sth->execute();
          // $object = $sth->fetch(PDO::FETCH_ASSOC);
          $list = $sth->fetchAll(PDO::FETCH_ASSOC);

        ?>


        <div class="checkselect">
            <label><input type="checkbox" name="adm[]" value="1" checked> Северо-Восточный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="2">Юго-Западный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="3">Юго-Восточный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="4">Центральный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="5">Западный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="6">Южный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="7">Восточный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="8">Зеленоградский административный округ</label>
            <label><input type="checkbox" name="adm[]" value="9">Северный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="10">Северо-Западный административный округ</label>
            <label><input type="checkbox" name="adm[]" value="11">Новомосковский административный округ</label>
            <div id="log"></div>
        </div>

       
        
        <div id="map" style="width: 100%; height:500px"></div>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU" type="text/javascript"></script>
        <script type="text/javascript">
            ymaps.ready(init);
            function init() {
                var myMap = new ymaps.Map("map", {
                    center: [<?php echo $list[0]['point']; ?>],
                    zoom: 16
                }, {
                    searchControlProvider: 'yandex#search'
                });
            
                var myCollection = new ymaps.GeoObjectCollection(); 
            
                <?php foreach ($list as $row): ?>

                // Добавим метку розового цвета.
                var myPlacemark = new ymaps.Placemark([
                    <?php
                        echo $row['point']; ?>
                ], {
                    balloonContent: '<?php 
                        $a = $row['Photo'];
                        $photo = "https://op.mos.ru/MEDIA/showFile?id=$a";
                        echo $photo; 
                        ?>'    
                        
                }, {
                    preset: 'islands#icon',
                    iconColor: 'rgb(253, 147, 147)' 
                });
                myCollection.add(myPlacemark);
                <?php endforeach; ?>
            
                myMap.geoObjects.add(myCollection);

                // Сделаем у карты автомасштаб чтобы были видны все метки.
                myMap.setBounds(myCollection.getBounds(),{checkZoomRange:true, zoomMargin:9});
                //zoomMargin - это отступы, которые должны соблюдаться при выставлении прямоугольных границ. 
            }
            
        </script>
        <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
<script>
(function($) {
	function setChecked(target) {
		var checked = $(target).find("input[type='checkbox']:checked").length;
		if (checked) {
			$(target).find('select option:first').html('Выбрано: ' + checked);
		} else {
			$(target).find('select option:first').html('Выберите из списка');
		}
	}

	$.fn.checkselect = function() {
		this.wrapInner('<div class="checkselect-popup"></div>');
		this.prepend(
			'<div class="checkselect-control">' +
				'<select class="form-control"><option></option></select>' +
				'<div class="checkselect-over"></div>' +
			'</div>'
		);	

		this.each(function(){
			setChecked(this);
		});		
		this.find('input[type="checkbox"]').click(function(){
			setChecked($(this).parents('.checkselect'));
		});

		this.parent().find('.checkselect-control').on('click', function(){
			$popup = $(this).next();
			$('.checkselect-popup').not($popup).css('display', 'none');
			if ($popup.is(':hidden')) {
				$popup.css('display', 'block');
				$(this).find('select').focus();
			} else {
				$popup.css('display', 'none');
			}
		});

		$('html, body').on('click', function(e){
			if ($(e.target).closest('.checkselect').length == 0){
				$('.checkselect-popup').css('display', 'none');
			}
		});
	};
})(jQuery);	

$('.checkselect').checkselect();
</script>


</body>

</html>
