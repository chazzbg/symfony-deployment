var $collectionHolder;

// setup an "add a actor" link
var $addActorLink = $('<a href="#" class="add_actor_link">Add a actor</a>');
var $newLinkLi = $('<li></li>').append($addActorLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of actors
    $collectionHolder = $('ul.actors');

    // add a delete link to all of the existing actor form li elements
    $collectionHolder.find('li').each(function() {
        addActorFormDeleteLink($(this));
    });


    // add the "add a actor" anchor and li to the actors ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addActorLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new actor form (see next code block)
        addActorForm($collectionHolder, $newLinkLi);
    });
});



function addActorForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a actor" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addActorFormDeleteLink($newFormLi);
}


function addActorFormDeleteLink($actorFormLi) {
    var $removeFormA = $('<a href="#">delete this actor</a>');
    $actorFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the actor form
        $actorFormLi.remove();
    });
}