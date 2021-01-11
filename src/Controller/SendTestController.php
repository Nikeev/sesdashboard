<?php

namespace App\Controller;

use App\Form\TestMailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendTestController extends BaseController
{
    /**
     * @Route("/send/test", name="app_send_test", methods="GET")
     */
    public function index()
    {
        // We don't load MailerInterface here to be sure that MAILER_DSN is configured.

        // Check if MAILER_DSN is configured.
        // Show configure instructions if not set.
        if (empty($_ENV['MAILER_DSN'])) {
            return $this->render('send_test/configure.html.twig');
        }

        // Fill default form values.
        $data = [
            'sendFrom' => $this->getUser()->getEmail(),
            'sendTo' => $this->getUser()->getEmail(),
            'configurationSet' => '',
            'subject' => 'SesDashboard test message',
            'message' => 'This is a test message!',
        ];

        $form = $this->createForm(TestMailType::class, $data);

        return $this->render('send_test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/send/test", name="app_send_test_post", methods="POST")
     */
    public function send(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(TestMailType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
                ->from($form->get('sendFrom')->getData())
                ->to(...explode(',', $form->get('sendTo')->getData()))
                ->subject($form->get('subject')->getData())
                ->html($form->get('message')->getData());

            if ($configurationSet = $form->get('configurationSet')->getData()) {
                $email->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', $configurationSet);
            }

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Message was not sent :(');
                return $this->redirectToRoute('app_send_test');
            }

            $this->addFlash('success', 'Message was sent!');

            return $this->redirectToRoute('app_send_test');
        }

        return $this->render('send_test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
