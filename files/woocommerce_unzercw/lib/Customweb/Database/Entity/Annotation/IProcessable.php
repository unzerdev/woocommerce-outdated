<?php


interface Customweb_Database_Entity_Annotation_IProcessable {

	public function process(Customweb_Database_Entity_Meta_IEntity $entity, Reflector $reflector);

	public function reset();

}