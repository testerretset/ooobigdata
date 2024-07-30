<?php
// Базовый класс tests
class tests {
    // Метод run, который будет переопределен в дочерних классах
    public function run() {
        // Пустая реализация
    }
}

/** Пример 1 */
class example1 extends tests {
    public function run() {
        $a = '123456';
        //var_dump($a[$a[1]]);
        $a[$a[1]] = '2';
        //$a[1] - это '3', получается так, что мы делаем $a['3'] = '2'. В пыхе слабая типизация, можно через стринг указать элемент массива ))
        return $a;
    }
}

/** Пример 2 */
class example2 extends tests {
    public function run() {
        $item = 5; //<- анюзед, потому-что в цикле создается внутренняя переменная с таким-же именем
        $list = [1, 2, 3]; //
        foreach ($list as $item) {
            $item++;
            //echo "Текущее значение: $item\n";
        }
        //айтем редефайнится, и получается так, что айтем равен последнему значению массива лист, т.е 3 + 1 = 4
        return $item;
    }
}

/** Пример 3 */
class example_3_classA {
    public $foo = 1;
}

class example3 extends tests {
    public function run() {
        $a = new example_3_classA(); //создали класс A, в переменную $a
        $b = $a; //клонировали класс A из переменной $a в переменную $b
        //$b = clone $a; //если сделать так, то тогда выведет 1.
        $b->foo = 2; //присвоили значение 2, и значение обеих и $a->foo и $b->foo стало 2, потому-что в пыхе объекты передаются по ссылке в памяти. Т.е. ссылаются на одну ячейку в оперативке и "оба значения" переменных - изменяются, вернее меняется значение ячейки оперативки, а переменные которые запрашивают значение из этой ячейки получают одно и тоже значение
        //echo $a->foo." ".$b->foo;
        return $a->foo;
    }
}

/** Пример 4 */
interface example_4_interface_Foo {
    const A = 'Foo'; //создали константу A в интерфейсе
}
class example_4_classBar implements example_4_interface_Foo {
    const A = 'Bar'; //заредефайнили константу A в классе, я хз, чувствуется какой-то подкол )
}

class example4 extends tests {
    public function run() {
        return example_4_classBar::A; //из-за того, что мы заредефайнили A на Bar, вывело 'Bar'. Ну вроде изи, просто чувствуется, "что-то не так", из-за хитростей в пред. заданиях )
    }
}

/** Пример 5
 * Если честно с trait не работал, но слышал про это, что с помощью этого можно "состакать", "запихать" несколько классов в один.
 */
trait example_5_traitFoo {
    public function getName() {
        return "Foo"; //выведет это
    }
}
class example_5_classBar {
    public function getName() {
        return "Bar"; //я честно не до конца разобрался, как это тут сработало, но IDE мне пометило это как unused. Когда я выделяю getName выделяется getName в trait, а тут не выделяется, в этом классе.
    }
}
class example_5_classBaz extends example_5_classBar { //тут вроде мы экстендимся от класса
    use example_5_traitFoo { //а тут говорим что будем использовать трейт, скорее всего трейт имеет более высокий приоритет, при одинаковых значениях, соответственно getName вызывается из трейта, а не из класса
        example_5_traitFoo::getName as public getFooName; //тут была ошибка, я скинул Вам в ЛС. Сейчас же работает
    }
}

class example5 extends tests {
    public function run() {
        $baz = new example_5_classBaz();
        return $baz->getName();
    }
}


function main() {
    $examples = [
        new example1(),
        new example2(),
        new example3(),
        new example4(),
        new example5()
    ];
    foreach ($examples as $index => $example) {
        echo "Example ".($index+1)." | Output: ".$example->run()."\n";
    }
}

main();

?>
