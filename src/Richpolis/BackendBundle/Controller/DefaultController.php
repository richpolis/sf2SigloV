<?php

namespace Richpolis\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

use Richpolis\PublicacionesBundle\Entity\Publicacion;
use Richpolis\PublicacionesBundle\Form\PublicacionType;

use Richpolis\PublicacionesBundle\Entity\Galeria;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="backend_homepage")
     * @Template()
     */
    public function indexAction()
    {
        
    }
    
    /**
     * @Route("/usuarios", name="backend_usuarios")
     * @Template()
     */
    public function usuariosAction()
    {
        
    }
    
    /**
     * @Route("/categorias", name="backend_categorias")
     * @Template()
     */
    public function categoriasAction()
    {
        
    }
    
    /**
     * @Route("/publicaciones", name="backend_publicaciones")
     * @Template()
     */
    public function publicacionesAction()
    {
        
    }
    
    /**
     * @Route("/galerias", name="backend_galerias")
     * @Template()
     */
    public function galeriasAction()
    {
        return array('tipos'=>Galeria::getArrayTipoArchivos());
    }
    
    /**
     * @Route("/publicaciones/galerias", name="backend_publicaciones_galerias")
     * @Template()
     */
    public function publicacionesGaleriaAction(Request $request)
    {
        $id = $request->query->get('publicacion');
        $publicacion = $this->getDoctrine()->getRepository('PublicacionesBundle:Publicacion')
                ->find($id);
        return array("publicacion"=>$publicacion);
    }

    /**
     * @Route("/login", name="backend_login")
     * @Template()
     */
    
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'BackendBundle:Default:login.html.twig',
            array(
                // último nombre de usuario ingresado
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    /**
     * @Route("/login_check", name="backend_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="backend_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
    }
    
    
}
