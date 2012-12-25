..  Content substitution
	...................................................
	Hint: following expression |my_substition_value| will be replaced when rendering doc.

.. |author| replace:: Oliver Hader <oliver.hader@typo3.org>
.. |extension_key| replace:: workspaces_performance
.. |extension_name| replace:: Workspace Performance
.. |extension_version| replace:: 0.2.0
.. |creation_date| replace:: 25-12-2012
.. |typo3| image:: Images/Typo3.png
.. |time| date:: %m-%d-%Y %H:%M

..  Custom roles
	...................................................
	After declaring a role like this: ".. role:: custom", the document may use the new role like :custom:`interpreted text`. 
	Basically, this will wrap the content with a CSS class to be styled in a special way when document get rendered.
	More information: http://docutils.sourceforge.net/docs/ref/rst/roles.html

.. role:: code
.. role:: typoscript
.. role:: typoscript(code)
.. role:: ts(typoscript)
.. role:: php(code)
