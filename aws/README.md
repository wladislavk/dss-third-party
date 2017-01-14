# AWS stack for Docker deployment

All resources managed with `AWS CloudFormation`. [Troposphere](https://github.com/cloudtools/troposphere) is used to make it easy to manage `CloudFormation` templated and make them programatically.

## Media

This stack is to store and serve uploaded media files. Stack has an `S3 Bucket` for files and `CloudFront` as a *CDN* to deliver it's content. `CloudFront` is configured to serve files over *HTTPS* and forces this behavior. There is a `ManagedPolicy` created to give access to write to the bucket.
