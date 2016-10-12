
var $collection;
var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
var $newLinkLi= $('<tr></tr>').append($addTagLink);

jQuery(document).ready(function(){

      $collectionHolder = $('tbody.offres');
      //$collectionHolder.append($newLinkLi);

      //$collectionHolder.data('index', $collectionHolder.find(':input').length);

      /*$addTagLink.on('click', function(e){
        e.preventDefault();

        addTagForm($collectionHolder, $newLinkLi);
      });
      */
      //$collectionHolder.find('tr').each(function(){
      //  addTagFormDeleteLink($(this));

      //});
    });

    function addTagFormDeleteLink($tagFormLi){
      var $removeFormA = $('<td><a href="#" class="btn btn-danger"> Delete</a></td>');
      $tagFormLi.append($removeFormA);

      $removeFormA.on('click', function(e){
        e.preventDefault();
        $tagFormLi.remove();
      });
      }
    function addTagForm($collection, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collection.data('prototype');

    // get the new index
    var index = $collection.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collection.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<tr></tr>').append(newForm);
    $newLinkLi.before($newFormLi);
}


