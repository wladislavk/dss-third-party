from __future__ import print_function

from troposphere import Parameter, Template, Output
from troposphere import Ref, GetAtt, Join
from troposphere import constants as c, s3, cloudfront, iam

# TODO get CloudFront hosted zone id from a list (use lambda function)
CLOUDFRONT_HOSTED_ZONE_ID = 'Z2FDTNDATAQYW2'


template = Template()


bucket_name = template.add_parameter(Parameter(
    'BucketName',
    Type=c.STRING,
    Default='dev.media.ds3',
    Description='A bucket to store media files',
))


root_bucket = template.add_resource(s3.Bucket(
    'MediaBucket',
    AccessControl=s3.PublicRead,
    BucketName=Ref(bucket_name),
))
root_bucket_arn = Join('', ['arn:aws:s3:::', Ref(root_bucket), '/*'])

# Allow everybody to read from the bucket
template.add_resource(s3.BucketPolicy(
    'MediaBucketPolicy',
    Bucket=Ref(root_bucket),
    PolicyDocument={
        'Statement': [{
            'Action': ['s3:GetObject'],
            'Effect': 'Allow',
            'Resource': root_bucket_arn,
            'Principal': '*',
        }]
    }
))

# Create managed policy for bucket writers
template.add_resource(iam.ManagedPolicy(
    'MediaBucketWriter',
    PolicyDocument={
        'Version': '2012-10-17',
        'Statement': [{
            'Action': ['s3:*'],
            'Effect': 'Allow',
            'Resource': root_bucket_arn,
        }]
    }
))


cdn = template.add_resource(cloudfront.Distribution(
    'MediaDistribution',
    DistributionConfig=cloudfront.DistributionConfig(
        Origins=[cloudfront.Origin(
            Id=Ref(root_bucket),
            DomainName=GetAtt(root_bucket, 'DomainName'),
            S3OriginConfig=cloudfront.S3Origin()
        )],
        DefaultCacheBehavior=cloudfront.DefaultCacheBehavior(
            Compress=True,
            ForwardedValues=cloudfront.ForwardedValues(QueryString=False),
            TargetOriginId=Ref(root_bucket),
            ViewerProtocolPolicy='redirect-to-https'
        ),
        Enabled=True
    )
))

template.add_output(Output(
    'CDNDomain',
    Value=GetAtt(cdn, 'DomainName')
))


print(template.to_json(indent=2))
