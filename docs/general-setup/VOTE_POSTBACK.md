# VotePostBack

_*** Beta please PM me to get this Beta-Version ***_

following providers are supported
- gamestop100
- xtremetop100
- gtop100
- silkroad-server
- private-server
- topg


## Create a VotePage

First you have to create a VotePage in the Adminpanel, with the type `postback`.
In the url you have to add the placeholder for the user-id like `http://www.xtremetop100.com/in.php?site=XXXXX&postback=%s`

## PostBackUrl

The postbackUrl is `https://your-site.com/panel/vote-postback/:provider:/:voteSiteId:`.

You have to replace following
- `:provider:` with one of the providers above
- `:voteSiteId:` here you have to use the voteId, which you can find in the adminpanel-vote section `#`.
