===========================================================
Developer Corner
===========================================================

Target group: **Developers**


XClasses
===========================================================

There are two XClasses that override the functionality of
Tx_Workspaces_Service_GridData and Tx_Workspaces_Service_Workspaces - basically
to optimize fetching and iterating over nested pages structures and to override
the expensive calculation of changes for each versioned record in a workspace.


Extbase Bootstrap
===========================================================

An alternative implementation of Tx_Extbase_Configuration_BackendConfigurationManager
is registered for the back-end module dispatcher to override the default
(time-consuming) bootstrap mechanism of Extbase to determine accordant TypoScript.
The hard-coded configuration is located in the Configuration folder of this
extension.

This alternative is only activated if the workspaces module is called in the back-end.
