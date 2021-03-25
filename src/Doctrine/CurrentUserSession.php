<?php


namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\DayCheck;
use App\Entity\Diet;
use App\Entity\Hearth;
use App\Entity\Resident;
use App\Entity\Texture;
use App\Entity\Unity;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;


class CurrentUserSession implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $checker)
    {
        $this->security = $security;
        $this->auth = $checker;
    }
    private function addWhere( QueryBuilder $queryBuilder,  string $resourceClass){

        // 1.obtenir l'user connecté.
        $user = $this->security->getUser();

        // si on demande des entités(hearth, user, unité, résident, diet, texture; dayCheck) agir sur la requete pour qu'elle tienne compte de l'utilisateur connecté et de hearth_id
        // et si c'est un admin il peut tous voir et si il est connecté
        if(($resourceClass === Hearth::class ||
            $resourceClass === Unity::class ||
            $resourceClass === User::class ||
            $resourceClass === Resident::class ||
            $resourceClass === Diet::class ||
            $resourceClass === Texture::class ||
            $resourceClass === DayCheck::class ) &&
            !$this->auth->isGranted('ROLE_ADMIN') &&
            //TODO : ADMIN est ce qu il a le droit d'acceder a tous ?
            $user instanceof User
        ){

            $userHearth = $user->getHearth();
            $rootAlias = $queryBuilder->getRootAliases()[0];

            if($resourceClass === Hearth::class ){
                $queryBuilder->andWhere("$rootAlias = :userHearth");

            }elseif($resourceClass === User::class ){
                $queryBuilder->join("$rootAlias.hearth", "u")
                    ->andWhere("u = :userHearth");

            }elseif($resourceClass === Unity::class  ){
                $queryBuilder->join("$rootAlias.hearth", "h")
                    ->andWhere("h = :userHearth");

            }elseif($resourceClass === Resident::class  ){
                $queryBuilder->join("$rootAlias.unity", "uny")
                    ->andWhere("uny = :userHearth");

                //TODO : probleme de sécurité acces !
            }elseif($resourceClass === Diet::class  ){
                $queryBuilder->join("$rootAlias.resident", "d")
                    ->andWhere("d = :userHearth");

                //TODO : probleme de sécurité acces !
            }elseif($resourceClass === Texture::class ){
                $queryBuilder->join("$rootAlias.resident", "t")
                    ->andWhere("t = :userHearth");

                //TODO : probleme de sécurité acces !
            }elseif($resourceClass === DayCheck::class  ){
                $queryBuilder->join("$rootAlias.resident", "dw")
                    ->andWhere("dw = :userHearth");
            }



            $queryBuilder->setParameter("userHearth",$userHearth);
        }

    }


    // permetre de recuperer ce qui ce passe apres les requetes avec querybuilder

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator,
                                      string $resourceClass, string $operationName = null){

        $this->addWhere( $queryBuilder,  $resourceClass);

    }




    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator,
                                string $resourceClass, array $identifiers, string $operationName = null, array $context = []){

        $this->addWhere( $queryBuilder,  $resourceClass);

    }
}