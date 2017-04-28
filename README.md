A sample symfony project regarding lecture 23 SYMFONY ADVANCED - FORMS AND EVENTS
project is based on the code used in lecture 22

Defining simple transformer for transforming tags from array to string and reverse

Defining a transformer with access to entity manager for converting category to id and reverse

Two new entities are added Actor and Movie and CRUD is generated for it 
A collection of forms is defined for actors in movie form so we can add them dynamically 

An exception listener is registered for listening for kernel exception
this listener will check if the exception is NotFoundHttpException and  render custom response , replacing the actual one 
