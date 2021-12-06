echo '_____________START DEPLOY____________'
export $(grep -v '^#' .env | xargs)
aws s3 cp dist s3://${S3_BUCKET}/dist --recursive
echo '_____________END DEPLOY____________'