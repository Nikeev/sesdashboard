<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendTestController extends BaseController
{
    /**
     * @Route("/send/test", name="app_send_test")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $data = [
            'sendFrom' => $this->getUser()->getEmail(),
            'sendTo' => $this->getUser()->getEmail(),
        ];

        $form = $this->createFormBuilder($data)
            ->add('sendFrom', EmailType::class)
            ->add('sendTo', TextType::class)
            ->add('subject', TextType::class)
            ->add('message', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($form->get('sendFrom')->getData())
                ->to(...explode(',', $form->get('sendTo')->getData()))
                ->subject($form->get('subject')->getData())
                ->html($form->get('message')->getData());

            $email->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', 'Tracking');

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Message was not sent.');
            }

            $this->addFlash('success', 'Message was sent.');
        }

        return $this->render('send_test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
