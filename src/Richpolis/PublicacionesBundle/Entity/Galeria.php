<?php

namespace Richpolis\PublicacionesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Richpolis\BackendBundle\Utils\Richsys as RpsStms;

use JMS\Serializer\Annotation as Serializer;

/**
 * Galeria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Richpolis\PublicacionesBundle\Entity\GaleriaRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @Serializer\ExclusionPolicy("all")
 */
class Galeria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255,nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255,nullable=true)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=255)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="archivo", type="string", length=255)
     * 
     * @Serializer\Expose
     * @Serializer\Type("string")
     */
    private $archivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipoArchivo", type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $tipoArchivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     * 
     * @Serializer\Expose
     * @Serializer\Type("integer")
     */
    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     * 
     * @Serializer\Expose
     * @Serializer\Type("boolean")
     */
    private $isActive;

    /**
     * @var \Publicacion
     *
     * @ORM\ManyToOne(targetEntity="Publicacion", inversedBy="galerias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="publicacion_id", referencedColumnName="id") 
     * })
     * 
     * @Serializer\Expose
     * @Serializer\Type("Richpolis\PublicacionesBundle\Entity\Publicacion")
     */
    private $publicacion;
    
    const IMAGEN=1;
    const LINK_VIDEO=2;
    const OTRO=3;
    
    
    static private $sTipoArchivos=array(
        self::IMAGEN=>'Imagen',
        self::LINK_VIDEO=>'Link video',
        self::OTRO=>'Otro',
    );
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("stringTipo")
     * 
     */
    public function getStringTipoArchivo(){
        return self::$sTipoArchivos[$this->getTipoArchivo()];
    }

    static function getArrayTipoArchivos(){
        return self::$sTipoArchivos;
    }

    static function getPreferedTipoArchivo(){
        return array(self::IMAGEN);    
    }

    /* Constructor */
    public function __construct(){
        $this->isActive = true;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Galeria
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Galeria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return Galeria
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set archivo
     *
     * @param string $archivo
     * @return Galeria
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;

        return $this;
    }

    /**
     * Get archivo
     *
     * @return string 
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * Set tipoArchivo
     *
     * @param integer $tipoArchivo
     * @return Galeria
     */
    public function setTipoArchivo($tipoArchivo)
    {
        $this->tipoArchivo = $tipoArchivo;

        return $this;
    }

    /**
     * Get tipoArchivo
     *
     * @return integer 
     */
    public function getTipoArchivo()
    {
        return $this->tipoArchivo;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Galeria
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Galeria
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set publicacion
     *
     * @param \Richpolis\PublicacionesBundle\Entity\Publicacion $publicacion
     * @return Galeria
     */
    public function setPublicacion(\Richpolis\PublicacionesBundle\Entity\Publicacion $publicacion = null)
    {
        $this->publicacion = $publicacion;

        return $this;
    }

    /**
     * Get publicacion
     *
     * @return \Richpolis\PublicacionesBundle\Entity\Publicacion 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }
    
    
    
    /**
     * Regresa el titulo corto segun el maximo de caracteres solicitado
     * 
     * @return string
     * 
     */
    
    public function getTituloCorto($max=15){
        if($this->titulo)
            return substr($this->getTitulo(), 0, $max);
        else
            return "Sin titulo";
    }
    
    /*
     * Crea el thumbnail y lo guarda en un carpeta dentro del webPath thumbnails
     * 
     * @return void
     */
    public function crearThumbnail($width=120,$height=100,$path=""){
        $this->thumbnail=$this->archivo;
        $imagine= new \Imagine\Gd\Imagine();
        $mode= \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;
        $image     = $imagine->open($this->getAbsolutePath());
        $sizeImage = $image->getSize();
        if(strlen($path)==0){
            $path = $this->getAbosluteThumbnailPath();
        }
        if($height == null){
            $height = $sizeImage->getHeight();
            if($height>369){
                $height = 369;
            }
        }
        if($width == null){
            $width = $sizeImage->getWidth();
            if($width>638){
                $width = 638;
            }
        }
        $size=new \Imagine\Image\Box($width,$height);
        $image->thumbnail($size,$mode)->save($path);        
    }
    
    
    /*
     * Para guardar videos de youtube o vimeo
     * 
     */
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preSaveGaleria()
    {
      if ($this->getTipoArchivo()==  Galeria::LINK_VIDEO) {
        $infoVideo=  RpsStms::getTitleAndImageVideoYoutube($this->getArchivo());
        $this->setThumbnail($infoVideo['thumbnail']);
        $this->setArchivo($infoVideo['urlVideo']);
        $this->setTitulo($infoVideo['title']);
        $this->setDescripcion($infoVideo['description']);
      }
    }

    
    /*** uploads ***/
    
    public $file;
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function preUpload()
    {
      if (null !== $this->file) {
        // do whatever you want to generate a unique name
        $this->archivo       =   uniqid().'.'.$this->file->guessExtension();
        $this->thumbnail    =   $this->archivo;
      }
    }

    /**
    * @ORM\PostPersist
    * @ORM\PostUpdate
    */
    public function upload()
    {
      if (null === $this->file) {
        return;
      }

      // if there is an error when moving the file, an exception will
      // be automatically thrown by move(). This will properly prevent
      // the entity from being persisted to the database on error
      $this->file->move($this->getUploadRootDir(), $this->archivo);

      $this->crearThumbnail();
      
      unset($this->file);
    }

    /**
    * @ORM\PostRemove
    */
    public function removeUpload()
    {
      if ($file = $this->getAbsolutePath()) {
        if(file_exists($file)){
            unlink($file);
        }
      }
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
        }
      }
      
      if($medium=$this->getAbosluteMediumPath()){
         if(file_exists($medium)){
            unlink($medium);
        }
      }
      
      if($large=$this->getAbosluteLargePath()){
         if(file_exists($large)){
            unlink($large);
        }
      }
      
    }
    
    protected function getUploadDir()
    {
        return '/uploads/galerias';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir();
    }
    
    protected function getThumbnailRootDir()
    {
        return __DIR__.'/../../../../web'.$this->getUploadDir().'/thumbnails';
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webPath")
     * 
     */
    public function getWebPath()
    {
        if($this->getTipoArchivo()==self::IMAGEN){
            return null === $this->archivo ? null : $this->getUploadDir().'/'.$this->archivo;
        }else{
            return $this->getArchivo();
        }
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webPathThumbnail")
     * 
     */
    public function getThumbnailWebPath()
    {
        if($this->getTipoArchivo()==self::IMAGEN){
            if(!file_exists($this->getAbosluteThumbnailPath())){
                if(file_exists($this->getAbsolutePath())){
                    $this->crearThumbnail();
                }
            }
            return null === $this->thumbnail ? null : $this->getUploadDir().'/thumbnails/'.$this->thumbnail;
        }else{
            return $this->getThumbnail();
        }
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webPathMedium")
     * 
     */
    public function getMediumWebPath()
    {
        if($this->getTipoArchivo()==self::IMAGEN){
            if(!file_exists($this->getAbosluteMediumPath())){
                if(file_exists($this->getAbsolutePath())){
                    $this->crearThumbnail(300,null,$this->getAbosluteMediumPath());
                }
            }
            return null === $this->thumbnail ? null : $this->getUploadDir().'/thumbnails/medium/'.$this->thumbnail;
        }else{
            return $this->getThumbnail();
        }
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("webPathLarge")
     * 
     */
    public function getLargeWebPath()
    {
        if($this->getTipoArchivo()==self::IMAGEN){
            if(!file_exists($this->getAbosluteLargePath())){
                if(file_exists($this->getAbsolutePath())){
                    $this->crearThumbnail(638,369,$this->getAbosluteLargePath());
                }
            }
            return null === $this->thumbnail ? null : $this->getUploadDir().'/thumbnails/large/'.$this->thumbnail;
        }else{
            return $this->getThumbnail();
        }
    }
    
    public function getAbsolutePath()
    {
        return null === $this->archivo ? null : $this->getUploadRootDir().'/'.$this->archivo;
    }
    
    public function getAbosluteThumbnailPath(){
        return null === $this->thumbnail ? null : $this->getUploadRootDir().'/thumbnails/'.$this->thumbnail;
    }
    
    public function getAbosluteMediumPath(){
        return null === $this->thumbnail ? null : $this->getUploadRootDir().'/thumbnails/medium/'.$this->thumbnail;
    }
    
    public function getAbosluteLargePath(){
        return null === $this->thumbnail ? null : $this->getUploadRootDir().'/thumbnails/large/'.$this->thumbnail;
    }
    
    /* nota: Actualizar para los nuevos thumbnails
     */
    public function actualizaThumbnail()
    {
      if($thumbnail=$this->getAbosluteThumbnailPath()){
         if(file_exists($thumbnail)){
            unlink($thumbnail);
         }
      }
      $this->crearThumbnail();
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("archivoView")
     * 
     */
    public function getArchivoView(){
        $opciones=array(
            'tipo_archivo'  => RpsStms::getTipoArchivo($this->getArchivo()),
            'path'      =>  $this->getLargeWebPath(),
            'carpeta'   =>  'galerias',
            'width'     =>  638,
            'height'    =>  369,
        );
        
        return RpsStms::getArchivoView($opciones);
    }
    
    public function getWidth(){
    
        
    }
    public function getHeight(){
    
        
    }
    
    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("isImagen")
     * 
     */
    public function getIsImagen(){
        if($this->getTipoArchivo()==self::IMAGEN)
            return true;
        else
            return false;
    }
}