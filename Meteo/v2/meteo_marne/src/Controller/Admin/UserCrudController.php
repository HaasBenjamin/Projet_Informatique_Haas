<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->userPasswordHasherInterface = $passwordHasher;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ArrayField::new('roles')
                ->formatValue(function ($value) {
                    $roles = "";
                    foreach ($value as $val) {
                        if ('ROLE_ADMIN' == $val) {
                            $roles.='<span class="material-symbols-outlined">manage_accounts</span>';
                        }
                        if ('ROLE_USER' == $val) {
                            $roles.='<span class="material-symbols-outlined">person</span>';
                        }
                    }
                    return $roles;
                }),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'empty_data' => '',
                    'attr' => ['autocomplete' => 'new-password'],
                ])->onlyOnForms(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::updateEntity($entityManager, $entityInstance);
        $request = $this->getContext()->getRequest();
        $password = $request->get('User')['password'];
        $this->setUserPassword($password, $entityInstance, $entityManager);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        parent::persistEntity($entityManager, $entityInstance);
        $request = $this->getContext()->getRequest();
        $password = $request->get('User')['password'];
        $this->setUserPassword($password, $entityInstance, $entityManager);
        $entityManager->flush();
    }

    public function setUserPassword(?string $password, $entityInstance, EntityManagerInterface $entityManager): void
    {
        if ('' != $password) {
            $entityInstance->setPassword($this->userPasswordHasherInterface->hashPassword($entityInstance, $password));
        }
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets->addCssFile('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined');
    }
}
