<p>
  <?php foreach($terms as $term): ?>
    <input type="radio" name="course" id="taxonomy_term_<?php echo $term->term_id;?>" value="<?php echo $term->term_id;?>"<?php if($term->term_id==$currentTaxonomyValue->term_id) echo "checked"; ?>>
    <label for="taxonomy_term_<?php echo $term->term_id;?>"><?php echo $term->name; ?></label>
    </input><br/>
  <?php endforeach; ?>
</p>