<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\Store\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("", name="cms_")
 */
class CmsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $contactEmailAddress;

    private $productRepository;

    public function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer, string $contactEmailAddress, ProductRepository $productRepository)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->contactEmailAddress = $contactEmailAddress;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('cms/homepage.html.twig',[
            'products'=>$this->productRepository->findLastProduct(),
            'productsPlusCommente'=>$this->productRepository->FindMoreComment(),
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentation()
    {
        return $this->render('cms/presentation.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($contact);
            $this->em->flush();

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom($contact->getEmail())
                ->setTo($this->contactEmailAddress)
                ->setBody(
                    $this->renderView('email/contact.html.twig', ['contact' => $contact]),
                    'text/html'
                );

            $this->mailer->send($message);

            $this->addFlash('success', 'Merci, votre message a été pris en compte !');

            return $this->redirectToRoute('cms_contact');
        }

        return $this->render('cms/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
