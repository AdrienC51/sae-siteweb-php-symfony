<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;


class DeliveryCrudController extends AbstractCrudController
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('deliveryDate'),
            AssociationField::new('orders')->setFormTypeOptions(['choice_label'=> function (Order $order): string {
                return $order->getId().'-'.$order->getOrderDate()->format('d/m/Y').'-'.$order->getClient()->getAccount()->getFirstName().' '.$order->getClient()->getAccount()->getLastName();
            }])
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUpdateOrders($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUpdateOrders($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
        $entityManager->flush();

    }

    public function setUpdateOrders(Delivery $delivery): void
    {
        $allOrders = $this->orderRepository->findAll();

        if (isset($this->getContext()->getRequest()->get("Delivery")['orders'])) {
            $ordersId = $this->getContext()->getRequest()->get('Delivery')['orders'];
            foreach ($allOrders as $order) {
                if ($order->getDelivery() === $delivery) {
                    if (!in_array($order->getId(), $ordersId)) {
                        $order->setDelivery(null);
                    }
                } elseif (in_array($order->getId(), $ordersId)) {
                    $order->setDelivery($delivery);
                }
            }
        } else {
            foreach ($allOrders as $order) {
                if ($order->getDelivery() === $delivery) {
                    $order->setDelivery(null);
                }
            }

        }
    }


}
