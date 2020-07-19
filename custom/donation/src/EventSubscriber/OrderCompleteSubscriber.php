<?php

namespace Drupal\donation\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Drupal\Core\Entity\EntityTypeManager;


class OrderCompleteSubscriber implements EventSubscriberInterface
{


  protected $entityTypeManager;


  public function __construct(EntityTypeManager $entity_type_manager)
  {
    $this->entityTypeManager = $entity_type_manager;
  }


  static function getSubscribedEvents()
  {
    $events['commerce_order.place.post_transition'] = ['orderCompleteHandler'];

    return $events;
  }


  public function orderCompleteHandler(WorkflowTransitionEvent $event)
  {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $event->getEntity();
    $mail = $order->getEmail();
    $config = \Drupal::config('donation.mailconfiguration');
    $subject = $config->get('donation_mail_subject');
    $body = $config->get('donation_mail_body');
    $this->sendmail($subject, $body, $mail);
    \Drupal::messenger()->addStatus('order placed successfully. Donation receipt has been mailed.');
  }
  function sendmail($subject, $body, $to)
  {
    $mailManager = \Drupal::service('plugin.manager.mail');
    $langcode = \Drupal::currentUser()->getPreferredLangcode();
    $params['context']['subject'] = $subject;
    $params['context']['message'] = $body;
    $mailManager->mail('system', 'mail', $to, $langcode, $params);
  }
}
