<?php

namespace src\controller {

    use Silex\Application;
use Silex\ControllerProviderInterface;

    class IndexController implements ControllerProviderInterface {

        public function index() {
            return 'Bonjour';
        }

        public function info() {
            return phpinfo();
        }

        public function form() {

            $form = <<< END_OF_FORM
                    <form action="feedback" method="POST">
                        Name : <input name="name" value=""/><br/>
                        <input type="submit" value="valider"/>
                    </form>
END_OF_FORM;
            return $form;
        }

        public function twigr(Application $app) {
            return $app['twig']->render('home.html.twig', array(
                        'val' => "ma valeur",
            ));
        }

        public function connect(Application $app) {
            // créer un nouveau controller basé sur la route par défaut
            $index = $app['controllers_factory'];
            $index->match("/", 'src\controller\IndexController::index');
            $index->match("/index", 'src\controller\IndexController::index');
            $index->match("/info", 'src\controller\IndexController::info');
            $index->match("/form", 'src\controller\IndexController::form');
            $index->match("/twig", 'src\controller\IndexController::twigr');




            return $index;
        }

    }

}

