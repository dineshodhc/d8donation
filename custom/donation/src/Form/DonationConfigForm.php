<?php

namespace Drupal\donation\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class DonationConfigForm extends ConfigFormBase
{

  function getEditableConfigNames()
  {

    return ['donation.mailconfiguration'];
  }

  function getFormId()
  {

    return 'donation_mailconfig';
  }

  function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('donation.mailconfiguration');
    $form['mail_subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
      '#description' => $this->t('Subject of the mail'),
      '#default_value' => $config->get('donation_mail_subject'),
      '#required' => true,
    ];

    $form['mail_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Body'),
      '#description' => $this->t('body of the mail'),
      '#default_value' => $config->get('donation_mail_body'),
      '#required' => true,
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    parent::submitForm($form, $form_state);
    $this->config('donation.mailconfiguration')
      ->set('donation_mail_subject', $form_state->getValue('mail_subject'))
      ->save();
    $this->config('donation.mailconfiguration')
      ->set('donation_mail_body', $form_state->getValue('mail_body'))
      ->save();

  }
}
