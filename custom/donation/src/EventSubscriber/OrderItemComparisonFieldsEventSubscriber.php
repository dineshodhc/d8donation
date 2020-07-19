<?php

namespace Drupal\donation\EventSubscriber;

use Drupal\commerce_cart\Event\CartEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\commerce_cart\Event\OrderItemComparisonFieldsEvent;


class OrderItemComparisonFieldsEventSubscriber implements EventSubscriberInterface
{


  public function onOrderItemComparison(OrderItemComparisonFieldsEvent $event)
  {

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents()
  {

  }
}
