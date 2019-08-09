# Intouchables - Symfony and Kubernetes

> Examples for the talk "Intouchable - Symfony and Kubernetes"

This is a small application, meant to be an example for running PHP and especially Symfony applications in a 
Kubernetes cluster.

To test it, the easiest way is to install [minikube](https://github.com/kubernetes/minikube). The setup for the 
`IngressController` resource can be found as a deployment in the `deployment/kubernetes/setup` directory.

You will need all the container images to be build. To make this easier, there is a script in `build-docker.sh` that
does the build and the push. You may alter the `$REGISTRY` variable to the registry you desire (maybe docker-hub with
your own user).

Don't forget to use your own image names in the deployments locates under
`deployment/kubernetes/classic/application-deployment.yml` and
`deployment/kubernetes/react/application-deployment.yml`

After that there are two options to deploy the application:

1. The classic way: `kubectl apply -k deployment/kubernetes/classic`
2. The ReactPHP way: `kubectl apply -k deployment/kubernetes/react`

Have fun playing around with Kubernetes.
