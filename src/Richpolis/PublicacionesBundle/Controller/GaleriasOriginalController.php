<?php

namespace Richpolis\PublicacionesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Richpolis\PublicacionesBundle\Entity\Galeria;
use Richpolis\PublicacionesBundle\Form\GaleriaType;

/**
 * Galeria controller.
 *
 * @Route("/galerias")
 */
class GaleriasController extends Controller
{

    /**
     * Lists all Galeria entities.
     *
     * @Route("/", name="galerias")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PublicacionesBundle:Galeria')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Galeria entity.
     *
     * @Route("/", name="galerias_create")
     * @Method("POST")
     * @Template("PublicacionesBundle:Galeria:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Galeria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('galerias_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Galeria entity.
    *
    * @param Galeria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Galeria $entity)
    {
        $form = $this->createForm(new GaleriaType(), $entity, array(
            'action' => $this->generateUrl('galerias_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Galeria entity.
     *
     * @Route("/new", name="galerias_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Galeria();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Galeria entity.
     *
     * @Route("/{id}", name="galerias_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Galeria entity.
     *
     * @Route("/{id}/edit", name="galerias_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Galeria entity.
    *
    * @param Galeria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Galeria $entity)
    {
        $form = $this->createForm(new GaleriaType(), $entity, array(
            'action' => $this->generateUrl('galerias_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Galeria entity.
     *
     * @Route("/{id}", name="galerias_update")
     * @Method("PUT")
     * @Template("PublicacionesBundle:Galeria:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PublicacionesBundle:Galeria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Galeria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('galerias_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Galeria entity.
     *
     * @Route("/{id}", name="galerias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PublicacionesBundle:Galeria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Galeria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('galerias'));
    }

    /**
     * Creates a form to delete a Galeria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('galerias_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
