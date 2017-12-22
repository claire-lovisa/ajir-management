<?php
namespace App\Frontend\Modules\Quiz;

use \OCFram\BackController;
use \OCFram\HTTPRequest;
use \Entity\Quiz;
use \Entity\Question;
use \Entity\Reponse;

/**
* La classe QuizController a pour but de gérer les quiz de l'application.
*/
class QuizController extends BackController
{
  /**
   * Permet d'exécuter l'index des quiz.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeIndex(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Accueil des quiz');

    if ($this->app->user()->isAuthenticated()) {
      $manager = $this->managers->getManagerOf('Quiz');
      $listeQuiz = $manager->getList(0,$manager->count());
      $this->page->addVar('listeQuiz', $listeQuiz);
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet de jouer à un quiz.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeJouerQuiz(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Jouer à un quiz');

    if($this->app->user()->isAuthenticated()) {
      if($request->getData('idQuiz')!==null AND $request->getData('numQuestion')!==null) {

        $this->page->addVar('nbBonnesReponses', $request->getData('nbBonnesReponses'));
        $this->page->addVar('numQuestion', $request->getData('numQuestion'));

        $managerQuiz = $this->managers->getManagerOf('Quiz');
        $quiz = $managerQuiz->getUnique($request->getData('idQuiz'));
        $this->page->addVar('quiz', $quiz);

        $managerQuestion = $this->managers->getManagerOf('Question');

        $nbTotalQuestions = count($managerQuestion->getListQuestionDuQuiz($quiz->idQuiz()));
        $this->page->addVar('nbTotalQuestions', $nbTotalQuestions);

        $listeQuestions = $managerQuestion->getListQuestionDuQuiz($request->getData('idQuiz'));
        $question = $listeQuestions[$request->getData('numQuestion')];
        $this->page->addVar('question', $question);

        $managerReponse = $this->managers->getManagerOf('Reponse');
        $listeReponses = $managerReponse->getListReponseDuQuiz($question->idQuestion());
        $this->page->addVar('listeReponses', $listeReponses);

        $repEnvoyee = null;
        if($request->postExists('bouton0')){
          $repEnvoyee = 0;
        }
        else if($request->postExists('bouton1')) {
          $repEnvoyee = 1;
        }
        else if($request->postExists('bouton2')) {
          $repEnvoyee = 2;
        }
        else if($request->postExists('bouton3')) {
          $repEnvoyee = 3;
        }

        if($repEnvoyee !== null) {
          if($listeReponses[$repEnvoyee]->estCorrecte()==1) {
            $this->page->addVar('bonneReponse', '1');
          }
          else {
            $this->page->addVar('bonneReponse', '0');
          }
        }

      }
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet de faire le bilan d'un quiz.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeBilanQuiz(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Bilan du quiz');

    if($this->app->user()->isAuthenticated()) {
      $this->page->addVar('nbBonnesReponses', $request->getData('nbBonnesReponses'));
      $this->page->addVar('numQuestion', $request->getData('numQuestion'));

      $managerQuiz = $this->managers->getManagerOf('Quiz');
      $quiz = $managerQuiz->getUnique($request->getData('idQuiz'));
      $this->page->addVar('quiz', $quiz);

      $managerQuestion = $this->managers->getManagerOf('Question');
      $nbTotalQuestions = count($managerQuestion->getListQuestionDuQuiz($quiz->idQuiz()));
      $this->page->addVar('nbTotalQuestions', $nbTotalQuestions);
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet d'ajouter un quiz.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeAjouterQuiz(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Ajouter un quiz');

    if($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
      if($request->postExists('nomQuiz')) {
        $nomQuiz = $request->postData('nomQuiz');
        if($this->verificationNomQuizLibre($nomQuiz)) {

          $manager = $this->managers->getManagerOf('Quiz');
          $idQuiz = $manager->getFreeID();
          $quiz = New Quiz([
            'idQuiz' => $idQuiz,
            'nomQuiz' => $nomQuiz
          ]);
          $manager->add($quiz);
          $this->app->httpResponse()->redirect('/ajouter-question'.$idQuiz);
        }
        else {
          $this->app->user()->setFlash('Ce nom est déjà pris.');
        }
      }
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }

  /**
   * Permet d'ajouter une question à un quiz.
   *
   * @param HTTPRequest $request La requête HTTP d'accès à la page
  */
  public function executeAjouterQuestion(HTTPRequest $request)
  {
    $this->page->addVar('title', 'Ajouter une question');

    if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
      if($request->getData('idQuiz')!==null) {

        $idQuiz = $request->getData('idQuiz');
        $managerQuiz = $this->managers->getManagerOf('Quiz');
        $quiz = $managerQuiz->getUnique($idQuiz);

        $this->page->addVar('idQuiz', $idQuiz);
        $this->page->addVar('nomQuiz', $quiz->nomQuiz());

        if ($request->postExists('nomQuestion')) {
          $nomQuestion = $request->postData('nomQuestion');

          $manager = $this->managers->getManagerOf('Question');
          $idQuestion = $manager->getFreeID();
          $question = New Question([
            'idQuestion' => $idQuestion,
            'idQuiz' => $idQuiz,
            'nomQuestion' => $nomQuestion
          ]);
          $manager->add($question);
          $this->app->httpResponse()->redirect('/ajouter-reponse'.$idQuestion);

        }
      }
    }
    else {
      $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
      $this->app->httpResponse()->redirect('.');
    }
  }


    /**
     * Permet d'ajouter les réponses à une question à un quiz.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeAjouterReponse(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Ajouter des réponses');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idQuestion')!==null) {

          $idQuestion = $request->getData('idQuestion');
          $managerQuestion = $this->managers->getManagerOf('Question');
          $question = $managerQuestion->getUnique($idQuestion);
          $idQuiz = $question->idQuiz();

          $this->page->addVar('idQuiz', $idQuestion);
          $this->page->addVar('nomQuestion', $question->nomQuestion());

          if ($request->postExists('repCorrecte') && $request->postExists('reponse1') && $request->postExists('reponse2') && $request->postExists('reponse3') && $request->postExists('reponse4')) {
            $reponses = [$request->postData('reponse1'), $request->postData('reponse2'), $request->postData('reponse3'), $request->postData('reponse4')];
            $repCorrecte = $request->postData('repCorrecte');
            $manager = $this->managers->getManagerOf('Reponse');
            $i = 1;
            foreach($reponses as $rep) {
              $idReponse = $manager->getFreeID();

              if($i == $repCorrecte) {
                $reponse = New Reponse([
                'idReponse' => $idReponse,
                'idQuestion' => $idQuestion,
                'nomReponse' => $rep,
                'estCorrecte' => 1
                ]);
              }
              else {
                $reponse = New Reponse([
                'idReponse' => $idReponse,
                'idQuestion' => $idQuestion,
                'nomReponse' => $rep,
                'estCorrecte' => 0
                ]);
              }
              $manager->add($reponse);
              $i = $i + 1;
            }
            $this->app->httpResponse()->redirect('/ajouter-question'.$idQuiz);
          }
        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter l'index de modification des quiz.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeIndexModification(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Accueil des quiz');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        $manager = $this->managers->getManagerOf('Quiz');
        $listeQuiz = $manager->getList(0,$manager->count());
        $this->page->addVar('listeQuiz', $listeQuiz);
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter les suppressions des quiz.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeSupprimerQuiz(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Suppression d\'un quiz');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idQuiz')!==null) {
          $idQuiz = $request->getData('idQuiz');
          $managerQuiz = $this->managers->getManagerOf('Quiz');
          $quiz = $managerQuiz->getUnique($idQuiz);
          $this->page->addVar('quiz', $quiz);

          if($request->postExists('supprimer')) {
            $managerQuiz->delete($quiz->idQuiz());
            $this->app->httpResponse()->redirect('/quiz-update');
          }

        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter les modification des quiz.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeModifierQuiz(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Modification d\'un quiz');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idQuiz')!==null) {
          $idQuiz = $request->getData('idQuiz');
          $managerQuiz = $this->managers->getManagerOf('Quiz');
          $quiz = $managerQuiz->getUnique($idQuiz);
          $this->page->addVar('quiz', $quiz);

          $managerQuestion = $this->managers->getManagerOf('Question');
          $listeQuestions = $managerQuestion->getListQuestionDuQuiz($idQuiz);
          $this->page->addVar('listeQuestions', $listeQuestions);

          if($request->postExists('nouveauNomQuiz')) {
            $quiz->setNomQuiz($request->postData('nouveauNomQuiz'));
            $managerQuiz->modify($quiz);
            $this->app->httpResponse()->redirect('/quiz-update');
          }

        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter l'index de modification des questions.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeSupprimerQuestion(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Suppression d\'une question');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idQuestion')!==null) {
          $idQuestion = $request->getData('idQuestion');
          $managerQuestion = $this->managers->getManagerOf('Question');
          $question = $managerQuestion->getUnique($idQuestion);
          $this->page->addVar('question', $question);

          if($request->postExists('supprimer')) {
            $managerQuestion->delete($question->idQuestion());
            $this->app->httpResponse()->redirect('/modifier-quiz'.$question->idQuiz());
          }

        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter les modification des questions.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeModifierQuestion(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Modification d\'une question');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idQuestion')!==null) {
          $idQuestion = $request->getData('idQuestion');
          $managerQuestion = $this->managers->getManagerOf('Question');
          $question = $managerQuestion->getUnique($idQuestion);
          $this->page->addVar('question', $question);

          $managerReponse = $this->managers->getManagerOf('Reponse');
          $listeReponses = $managerReponse->getListReponseDuQuiz($idQuestion);
          $this->page->addVar('listeReponses', $listeReponses);

          if($request->postExists('nouveauNomQuestion')) {
            $question->setNomQuestion($request->postData('nouveauNomQuestion'));
            $managerQuestion->modify($question);
            $this->app->httpResponse()->redirect('/modifier-question');
          }

        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    /**
     * Permet d'exécuter les modification des réponses.
     *
     * @param HTTPRequest $request La requête HTTP d'accès à la page
    */
    public function executeModifierReponse(HTTPRequest $request)
    {
      $this->page->addVar('title', 'Modification d\'une réponse');

      if ($this->app->user()->isAuthenticated() AND ($this->app->user()->getAttribute('estValide') == '1') AND ($this->app->user()->getAttribute('droits') !== null) AND $this->app->user()->getAttribute('droits')>=2) {
        if($request->getData('idReponse')!==null) {
          $idReponse = $request->getData('idReponse');
          $managerReponse = $this->managers->getManagerOf('Reponse');
          $reponse = $managerReponse->getUnique($idReponse);
          $this->page->addVar('reponse', $reponse);

          if($request->postExists('nouveauNomReponse')) {
            $reponse->setNomReponse($request->postData('nouveauNomReponse'));
            $managerReponse->modify($reponse);
            $this->app->httpResponse()->redirect('/modifier-question'.$reponse->idQuestion());
          }

        }
      }
      else {
        $this->app->user()->setFlash('Vous ne pouvez pas accéder à cette page.');
        $this->app->httpResponse()->redirect('.');
      }
    }

    private function verificationNomQuizLibre($nomQuiz) {
      $countNomQuiz = $this->managers->getManagerOf('Quiz')->countNomQuiz(strtolower($nomQuiz));
      return $countNomQuiz==0;
    }

}
