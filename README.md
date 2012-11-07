# StructureFrame Helper
=====================

An ExpressionEngine plugin that reverse engineers a Structure Page URL to obtain additional info about that page.

## Usage

Assuming you have a StructureFrame Fieldtype setup with a field name of `ft_structure_page`, you could obtain that page's title with:

    {exp:channel:entries}
    
    	...

	    {exp:structureframe_helper url="{ft_structure_page}"}

    	...

	    
    {/exp:channel:entries}

### Parameters

`url=` The Structure Page's URL, which should be set to your fieldtype
`return=` Possible values are `title` (default) and `id`.

