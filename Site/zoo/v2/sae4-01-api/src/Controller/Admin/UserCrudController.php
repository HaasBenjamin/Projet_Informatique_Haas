<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
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
            TextField::new('password')
                ->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'empty_data' => '',
                    'attr' => ['autocomplete' => 'new-password'],
                ]),
            TextField::new('firstname'),
            TextField::new('lastname'),
            ArrayField::new('roles')
                ->formatValue(function (array $roles, User $user) {
                    $symbols = '';
                    if (in_array('ROLE_ADMIN', $user->getRoles())) {
                        $symbols .= '<span class="material-symbols-outlined">manage_accounts</span>';
                    }
                    if (in_array('ROLE_EMPLOYEE', $user->getRoles())) {
                        $symbols .= '<span class="material-symbols-outlined">badge</span>';
                    }
                    if (in_array('ROLE_USER', $user->getRoles())) {
                        $symbols .= '<span class="material-symbols-outlined">person</span>';
                    }

                    return $symbols;
                }),
            DateTimeField::new('dateOfBirth'),
            DateTimeField::new('hiringDate'),
            IntegerField::new('contractDuration'),
            DateTimeField::new('dateVisitor'),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUserPassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function setUserPassword($entityInstance): void
    {
        $password = $this->getContext()->getRequest()->get('User')['password'];
        if (!empty($password)) {
            $entityInstance->setPassword($this->userPasswordHasher->hashPassword($entityInstance, $entityInstance->getPassword()));
        }
    }
}
