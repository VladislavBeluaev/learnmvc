<?php
namespace Acme\helpers\fillRequiredTables; 
function fillDesctopPc($resource)
{
	if(!file_exists($resource)) throw new \Exception('Resource not found');
	$strJson = file_get_contents($resource);
	$etalon = ['Название компьютера'=>'','Изображение'=>'','Цена'=>'','Игровой системный блок'=>'','Операционная система'=>'',
				'Производитель процессора'=>'','Модель процессора'=>'','Тактовая частота'=>'','Максимальная тактовая частота'=>'',
				'Количество ядер'=>'','Объем оперативной памяти'=>'','Тип накопителя'=>'','Объем накопителя'=>'','Тип оптического привода'=>'','Производитель видеокарты'=>'','Модель видеокарты'=>'','Объем видеопамяти'=>'','Wi-Fi'=>''];
	$startArray = json_decode($strJson,true);
	$tmpArr = [];
	$computers = [];
	for($i = 0;$i<=47;$i++)
	{
		$startValues = $startArray['desctopItems'][$i];
		foreach ($startValues as $key => $value) {
			switch ($key) {
				case 'name1':
					$tmpArr['Название компьютера'] = $value;
					break;
					case 'desctopImage':
					$tmpArr['Изображение'] = $value;
					break;
					case 'price':
					$tmpArr['Цена'] = $value;
					break;
			}
		}
		$mainCharacters = $startArray['desctopItems'][$i]['desctopDetails'][0]['Characters'];
		$main = array_map(function($v){
		    return [$v['name'] => $v['value']];
		}, $mainCharacters);
		$iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($main));
		    foreach ($iter as $key=>$value) {
		    	$tmpArr[$key] = $value;
		    }
			$computer = [];
	    foreach ($etalon as $key => $value) {
	    	if(!isset($tmpArr[$key])) {
	    		$computer[$key] = "'Иформация отсутствует'";
	    		continue;
	    	}
	    	$computer[$key] ="'$tmpArr[$key]'";
	    }
	    $computers[] = $computer;
	}
	foreach ($computers  as $computer) {
		$values = implode(',',$computer);
		$query = "insert into desctoppc(`name_pc`,`image_pc`,`price`,`is_gaming`,`os`,`processor`,`processor_model`,`clock_frequency`,
`max_clock_frequency`,`core_num`,`ram`,`drive_type`,`drive_size`,`optical_drive_type`,`graphics_card_producer`,`graphics_card_model`,`graphics_card_size`,`wi_fi`) values(".$values.");";
		file_put_contents('database/scripts/new_install/fillDesctopPc.sql',$query."\n",FILE_APPEND | LOCK_EX);
	}
}

function fillMobile($resource)
{
	if(!file_exists($resource)) throw new \Exception('Resource not found');
	$strJson = file_get_contents($resource);
	$etalon = ['Название телефона'=>'','Изображение'=>'','Цена'=>'','Защита корпуса'=>'','Операционная система'=>'','Поддержка 2-х SIM-карт'=>'','Количество ядер'=>'','Частота'=>'','Объем оперативной памяти'=>'','Объем встроенной памяти'=>'','Диагональ'=>'','Разрешение экрана'=>'','Работа в 4G(LTE)-сетях'=>'','Камера'=>'','Емкость аккумулятора (мА*ч)'=>''];
	$startArray = json_decode($strJson,true);
	$tmpArr = [];
	$mobiles = [];
	for($i = 0;$i<=47;$i++)
	{
		$startValues = $startArray['MobileItems'][$i];
		foreach ($startValues as $key => $value) {
			switch ($key) {
				case 'name1':
					$tmpArr['Название телефона'] = $value;
					break;
					case 'cardImage':
					$tmpArr['Изображение'] = $value;
					break;
					case 'price':
					$tmpArr['Цена'] = $value;
					break;
			}
		}
		$mainCharacters = $startArray['MobileItems'][$i]['MobileDetails'][0]['Params'];
		$main = array_map(function($v){
		    return [$v['name'] => $v['value']];
		}, $mainCharacters);
		$iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($main));
		    foreach ($iter as $key=>$value) {
		    	$tmpArr[$key] = $value;
		    }
			$mobile = [];
	    foreach ($etalon as $key => $value) {
	    	if(!isset($tmpArr[$key])) {
	    		$mobile[$key] = "'Иформация отсутствует'";
	    		continue;
	    	}
	    	$mobile[$key] ="'$tmpArr[$key]'";
	    }
	    $mobiles[] = $mobile;
	}
	foreach ($mobiles  as $mobile) {
		$values = implode(',',$mobile);
		$query = "insert into mobile(`mobile_name`,`mobile_img`,`price`,`body_protection`,`os`,`support_2sim`,`core_num`,`clock_frequency`,`ram`,`internal_storage`,`screen_diag`,`screen_res`,`support_4g`,`camera`,`battery`) values(".$values.");";
		file_put_contents('database/scripts/new_install/fillMobiles.sql',$query."\n",FILE_APPEND | LOCK_EX);
	}
}

function fillMobileColors()
{
	$mysql = new \Pdo("mysql:host=localhost;dbname=e_shopper",'root','');
	if(!$mysql) throw new \PdoException($mysql->error());
	$query = "select pid,mobile_name from mobile";
	$result = $mysql->query($query);
	$mobiles = $result->fetchAll(\PDO::FETCH_ASSOC);
	//var_dump($mobiles);
	$query = "select pid,color_description_en from colors";
	$result = $mysql->query($query);
	if(!$result) throw new \PdoException($result->error());
	$colors = $result->fetchAll(\PDO::FETCH_ASSOC);
	$totalColorsWithMobiles = [];
	$subFilterFlag = false;
	foreach ($colors as $color) {
		foreach ($mobiles as $mobileName) {
			if(!isset(${$color['color_description_en']})) ${$color['color_description_en']} = [];

				if(strpos($mobileName['mobile_name'],$color['color_description_en'])!==FALSE)
				{
					switch ($color['color_description_en']) {
						case 'Gold':
							if(strpos($mobileName['mobile_name'],'Rose')!==FALSE)
								$subFilterFlag = true;
							break;
							case 'Grey':
							if(strpos($mobileName['mobile_name'],'Space')!==FALSE)
								$subFilterFlag = true;
							break;
							case 'Red':
							$pattern = '/.+\s\b(Red)\b/i';
							if(!preg_match($pattern,$mobileName['mobile_name']))
								$subFilterFlag = true;
							break;
					}
					if($subFilterFlag) {
						$subFilterFlag = false;
						continue;
					}
					${$color['color_description_en']}[] =[$mobileName['pid']=>(int)$color['pid']];
			}
		}
		$totalColorsWithMobiles[$color['color_description_en']] =${$color['color_description_en']}; 
	}
	$iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($totalColorsWithMobiles));
	

	foreach ($iter as $key => $value) {
	 	$query = 'insert into mobiles_colors(`fk_mobile`,`fk_color`) values( '.$key.','.$value.');';
	 	file_put_contents('database/scripts/new_install/fillMobiles_Colors.sql',$query."\n",FILE_APPEND | LOCK_EX);
	 }
}

function fillNote($resource)
{   if(!$resource) if(!file_exists($resource)) throw new \Exception('Resource not found');
    $strJson = file_get_contents($resource);
    $startArray = json_decode($strJson,true);
    $etalon = ['Название ноутбука'=>'','Короткое описание'=>'','Изображение'=>'','Игровой ноутбук'=>'','Операционная система'=>'','Диагональ'=>'','Разрешение'=>'',
        'Производитель процессора'=>'','Модель процессора'=>'','Тактовая частота'=>'',
        'Объем оперативной памяти'=>'','Тип оперативной памяти'=>'','Тип накопителя'=>'','Объем накопителя'=>'',
        'Производитель видеокарты'=>'','Модель видеокарты'=>'','Объем видеопамяти'=>'','WiMAX'=>'','Цена'=>''];
    $notebook = [];
    $allNotes = [];
    for($i = 0;$i<=23;$i++)
    {
        $notebooks = $startArray['NoteBookName'][$i];
        foreach ($notebooks as $param =>$value)
        {
            if($param=='BookName') {
                $pattern = '/.*(\(.+\))/';
                preg_match($pattern,$value,$matches);
                $notebook['Название ноутбука'] =  mb_substr($matches[0],0,-mb_strlen($matches[1])-1);
                $notebook['Короткое описание'] =  trim($matches[1],'()');

            }
            if($param=='StartImage') $notebook['Изображение'] =  $value;
            if($param=='Price') $notebook['Цена'] =  $value;
        }
        $mainParams = $startArray['NoteBookName'][$i]['MainParams'];
        $iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($mainParams));
        foreach ($iter as $key => $value){
            if($value=='Основные характеристики'||$value=='Экран'||$value=='Процессор'||$value=='Оперативная память'||$value=='Накопитель'||$value=='Графическая система'||$value=='Встроенное оборудование')
            {
                continue;
            }
            $tmpArr = explode(':',$value);
            if($tmpArr[0]=='Цвет') $notebook['Короткое описание'] .= "/".trim($tmpArr[1]);
            $notebook[$tmpArr[0]] = trim($tmpArr[1]);
        }
        $note = [];
        foreach ($etalon as $key => $value) {
            if(!isset($notebook[$key])) {
                $note[$key] = "'Иформация отсутствует'";
                continue;
            }
            $note[$key] ="'$notebook[$key]'";
        }
        $allNotes[] = $note;
    }
    var_dump($allNotes);
    foreach ($allNotes  as $note) {
        $values = implode(',',$note);
        $query = "insert into notebook(`notebook_name`,`short_description`,`notebook_image`,`is_gaming`,`os`,`screen_diag`,`screen_res`,`processor`,`processor_model`,`clock_frequency`,`ram`,`ram_type`,`drive_type`,`drive_size`,`graphics_card_producer`,`graphics_card_model`,`graphics_card_size`,`wi_fi`,`price`) values(".$values.");";
        file_put_contents('database/scripts/new_install/fillNoteBook.sql',$query."\n",FILE_APPEND | LOCK_EX);
    }
}
function fillNotebookColors()
{
    $mysql = new \Pdo("mysql:host=localhost;dbname=e_shopper",'root','');
    if(!$mysql) throw new \PdoException($mysql->error());
    $query = "select pid,short_description from notebook";
    $result = $mysql->query($query);
    $noutes = $result->fetchAll(\PDO::FETCH_ASSOC);
    //var_dump($mobiles);
    $query = "select pid,color_description_ru from colors";
    $result = $mysql->query($query);
    if(!$result) throw new \PdoException($result->error());
    $colors = $result->fetchAll(\PDO::FETCH_ASSOC);
    $totalColorsWithNotes = [];
    foreach ($colors as $color) {
        foreach ($noutes as $noute) {
            if(!isset(${$color['color_description_ru']})) ${$color['color_description_ru']} = [];

            if(strpos($noute['short_description'],$color['color_description_ru'])!==FALSE)
            {
                ${$color['color_description_ru']}[] =[$noute['pid']=>(int)$color['pid']];
            }
        }
        $totalColorsWithNotes[$color['color_description_ru']] =${$color['color_description_ru']};
    }
    $iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($totalColorsWithNotes));


    foreach ($iter as $key => $value) {
        $query = 'insert into notebooks_colors(`fk_notebook`,`fk_color`) values( '.$key.','.$value.');';
        file_put_contents('database/scripts/new_install/fillNotebooks_Colors.sql',$query."\n",FILE_APPEND | LOCK_EX);
    }
}

function fillTV($resource)
{
    if(!file_exists($resource)) throw new \Exception('Resource not found');
    $strJson = file_get_contents($resource);
    $startArray = json_decode($strJson,true);
    $etalon = ['Название тв'=>'','Изображение'=>'','Цена'=>'','Диагональ'=>'','Технология'=>'','Цифровой формат'=>'','Разрешение'=>'',
        'Поддержка HDR'=>'','Яркость'=>'','Контрастность'=>'',
        'Воспроизведение видео через USB'=>'','Smart TV'=>'','HDMI'=>'','Кол-во разъемов USB'=>'',
        'Wi-Fi'=>''];
    $tv = [];
    $tmpArr = [];
    $allTV = [];
    for($i = 0;$i<=23;$i++) {
        $startValues = $startArray['TVItems'][$i];
        foreach ($startValues as $key => $value) {
            switch ($key) {
                case 'name':
                    $tmpArr['Название тв'] = $value;
                    break;
                case 'TVImage':
                    $tmpArr['Изображение'] = $value;
                    break;
                case 'Price':
                    $tmpArr['Цена'] = $value;
                    break;
            }
        }
        $mainCharacters = $startArray['TVItems'][$i]['TVDetails'][0]['selection1'];

        $main = array_map(function ($v) {
            $pattern = '/\b(HD\-?)\b/';
            if (preg_match($pattern, $v['name'])) {
                return ['Цифровой формат' => $v['name']];
            }
            return [$v['name'] => $v['value']];
        }, $mainCharacters);
        $iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($main));
        foreach ($iter as $key => $value) {
            $tmpArr[$key] = $value;
        }
        foreach ($etalon as $key => $value) {

            if (!isset($tmpArr[$key])) {
                $tv[$key] = "'Иформация отсутствует'";
                continue;
            }
            $tv[$key] = "'$tmpArr[$key]'";
        }
        $allTV[] = $tv;
    }
    foreach ($allTV as $tv) {
            $values = implode(',', $tv);
            $query = "insert into tv(`tv_name`,`tv_img`,`price`,`screen_diag`,`screen_technology`,`digit_format`,`screen_res`,`isHDR`,
`brightness`,`contrast`,`video_throw_usb`,`smart_TV`,`count_HDMI`,`count_USB`,`wi_fi`) values(" . $values . ");";
            file_put_contents('database/scripts/new_install/fillTV.sql', $query . "\n", FILE_APPEND | LOCK_EX);
        }
}

function fillTablets($resource)
{
    if(!file_exists($resource)) throw new \Exception('Resource not found');
    $strJson = file_get_contents($resource);
    $etalon = ['Название планшета' => '', 'Изображение' => '', 'Цена' => '', 'Операционная система' => '', 'Тип экрана' => '', 'Диагональ' => '',
        'Разрешение' => '', 'Модель процессора' => '', 'Тактовая частота' => '', 'Максимальная тактовая частота' => '',
        'Количество ядер' => '', 'Встроенная память' => '', 'Оперативная память' => '', 'Wi-Fi' => '', '3G-модуль' => '', '4G (LTE)' => '',
        'Разрешение матрицы' => '', 'Фронтальная камера' => ''];
    $startArray = json_decode($strJson, true);
    $tmpArr = [];
    $tablets = [];
    for ($i = 0; $i <= 47; $i++) {
        $startValues = $startArray['tabletItems'][$i];
        foreach ($startValues as $key => $value) {
            switch ($key) {
                case 'name1':
                    $tmpArr['Название планшета'] = $value;
                    break;
                case 'imageCard':
                    $tmpArr['Изображение'] = $value;
                    break;
                case 'price':
                    $tmpArr['Цена'] = $value;
                    break;
            }
        }
        $mainCharacters = $startArray['tabletItems'][$i]['tabletDetails'][0]['details'];
        $main = array_map(function ($v) {
            return [$v['name'] => $v['selection1']];
        }, $mainCharacters);
        $iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($main));
        foreach ($iter as $key => $value) {
            $tmpArr[$key] = $value;
        }
        $tablet = [];
        foreach ($etalon as $key => $value) {
            if (!isset($tmpArr[$key])) {
                $tablet[$key] = "'Иформация отсутствует'";
                continue;
            }
            $tablet[$key] = "'$tmpArr[$key]'";
        }
        $tablets[] = $tablet;
    }
    var_dump($tablets);
    foreach ($tablets as $tablet) {
        $values = implode(',', $tablet);
        $query = "insert into tablet(`tablet_name`,`tablet_img`,`price`,`os`,`screen_type`,`screen_diag`,`screen_res`,`processor_model`,`clock_frequency`,`max_clock_frequency`,`core_num`,`internal_storage`,`ram`,`wi_fi`,`support_3g`,`support_4g`,`main_camera`,`front_camera`) values(" . $values . ");";
        file_put_contents('database/scripts/new_install/fillTablets.sql', $query . "\n", FILE_APPEND | LOCK_EX);
    }
}

function fillTabletColors()
{
    $mysql = new \Pdo("mysql:host=localhost;dbname=e_shopper",'root','');
    if(!$mysql) throw new \PdoException($mysql->error());
    $query = "select pid,tablet_name from tablet";
    $result = $mysql->query($query);
    $tablets = $result->fetchAll(\PDO::FETCH_ASSOC);
    //var_dump($tablets);
    $query = "select pid,color_description_en from colors";
    $result = $mysql->query($query);
    if(!$result) throw new \PdoException($result->error());
    $colors = $result->fetchAll(\PDO::FETCH_ASSOC);
    $totalColorsWithMobiles = [];
    $subFilterFlag = false;
    foreach ($colors as $color) {
        foreach ($tablets as $tablet) {
            if(!isset(${$color['color_description_en']})) ${$color['color_description_en']} = [];

            if(strpos($tablet['tablet_name'],$color['color_description_en'])!==FALSE)
            {
                switch ($color['color_description_en']) {
                    case 'Gold':
                        if(strpos($tablet['tablet_name'],'Rose')!==FALSE)
                            $subFilterFlag = true;
                        break;
                    case 'Grey':
                        if(strpos($tablet['tablet_name'],'Space')!==FALSE)
                            $subFilterFlag = true;
                        break;
                    case 'Red':
                        $pattern = '/.+\s\b(Red)\b/i';
                        if(!preg_match($pattern,$tablet['tablet_name']))
                            $subFilterFlag = true;
                        break;
                }
                if($subFilterFlag) {
                    $subFilterFlag = false;
                    continue;
                }
                ${$color['color_description_en']}[] =[$tablet['pid']=>(int)$color['pid']];
            }
        }
        $totalColorsWithMobiles[$color['color_description_en']] =${$color['color_description_en']};
    }
    var_dump($totalColorsWithMobiles);
    $iter = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($totalColorsWithMobiles));


    foreach ($iter as $key => $value) {
        $query = 'insert into tablets_colors(`fk_tablet`,`fk_color`) values( '.$key.','.$value.');';
        file_put_contents('database/scripts/new_install/fillTablets_Colors.sql',$query."\n",FILE_APPEND | LOCK_EX);
    }
}