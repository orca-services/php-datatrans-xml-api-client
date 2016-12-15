Datatrans Payment XML API Client Documentation
==============================================

This API client library allows you to use the
[Datatrans Payment XML API](https://www.datatrans.ch/showcase/).
without having to bother with the typical grunt work, such as
how to build and send the requests or how to interpret and process
the responses.

It provides a Factory class to generate API specific Request objects,
which have a simple and easy to understand interface.

Requests
--------

The available request types are:

- [Authorisation](Request/Authorisation.md) (not yet implemented)
- [Cancel](Request/Cancel.md)
- [Credit](Request/Credit.md)
- [Settlement](Request/Settlement.md)
- [Status](Request/Status.md)

Examples
--------

In the [examples folder](../examples/) there are example implementations
each requests.

Additional Resources
--------------------

- Datatrans showcase:
  https://www.datatrans.ch/showcase
- Technical documentation can be found on:
  https://www.datatrans.ch/showcase/documentations/technical-documentation
- Test card numbers can be found on:
  https://www.datatrans.ch/showcase/test-cc-numbers
