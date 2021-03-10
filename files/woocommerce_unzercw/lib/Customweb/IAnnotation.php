<?php

/**
 * This interface marks a class as annotation.
 * The implementation can implement the following methods:
 * <ul>
 * <li><strong>setData(array $data):</strong> This method is invoked, when the annotation is
 * initialized. The $data array contains the data annotated on the target. This data may be assigned by the class itself. When this method is not set, then the data is tried to may to public
 * properties of the annotation class.</li>
 * <li><strong>checkConstraints($target):</strong> This method is invoked to allow to check additional constraints on the Annotation.</li>
 * </ul>
 * 
 * Both methods are optional, hence when they are not present on the annotation they are not called and no exception is thrown.
 *
 * @author Thomas Hunziker
 */
interface Customweb_IAnnotation {
	
	
	
}