Manually create and use a volume with Azure Files share in Azure Kubernetes Service (AKS) : POC </br>
( ref: https://docs.microsoft.com/en-us/azure/aks/azure-files-volume )

```
# Change these four parameters as needed for your own environment
# ref: https://docs.microsoft.com/en-us/azure/aks/azure-files-volume
AKS_PERS_STORAGE_ACCOUNT_NAME=stdworkaks0404
AKS_PERS_RESOURCE_GROUP=1TL-120220-b1-RG
AKS_PERS_LOCATION=southeastasia
AKS_PERS_SHARE_NAME=aksshare0404

# Create a resource group
az group create --name $AKS_PERS_RESOURCE_GROUP --location $AKS_PERS_LOCATION

# Create a storage account
az storage account create -n $AKS_PERS_STORAGE_ACCOUNT_NAME -g $AKS_PERS_RESOURCE_GROUP -l $AKS_PERS_LOCATION --sku Standard_LRS

# Export the connection string as an environment variable, this is used when creating the Azure file share
export AZURE_STORAGE_CONNECTION_STRING=$(az storage account show-connection-string -n $AKS_PERS_STORAGE_ACCOUNT_NAME -g $AKS_PERS_RESOURCE_GROUP -o tsv)

# Create the file share
az storage share create -n $AKS_PERS_SHARE_NAME --connection-string $AZURE_STORAGE_CONNECTION_STRING

# Get storage account key
STORAGE_KEY=$(az storage account keys list --resource-group $AKS_PERS_RESOURCE_GROUP --account-name $AKS_PERS_STORAGE_ACCOUNT_NAME --query "[0].value" -o tsv)
#############################################

```
##  kubectl
```
kubectl create secret generic azure-secret --from-literal=azurestorageaccountname=$AKS_PERS_STORAGE_ACCOUNT_NAME --from-literal=azurestorageaccountkey=$STORAGE_KEY

##################################################

kubectl apply -f azurefile-mount-options-pv-pvc.yaml --namespace ratingsapp
kubectl apply -f azurefile-mount-options-pv-pvc.yaml --namespace ratingsapp


kubectl exec fuju-nginx-azfile-s1-789887b6cc-p9fnb -c 1st-c -n ratingsapp -- /bin/cat /usr/share/nginx/html/dateoutput.txt
kubectl exec fuju-nginx-azfile-s1-789887b6cc-p9fnb -c 2nd-c -n ratingsapp -- /bin/cat /mnt/html/dateoutput.txt
```