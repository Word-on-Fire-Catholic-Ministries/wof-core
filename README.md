# Word on Fire Core
A collection of libraries, tools, and shared functionality across WOF WordPress sites.

## Deploy procedures
1. Update composer.json to the next version
2. Final commit on feature branch
3. Push changes to origin
4. Create a pull request and merge the changes back into main
5. Switch to main and run (-f to force): 
```
git tag -a 1.0.4 -m "Refactored Category Indexing"
```
6. Push the tag with (-f to force):
```
git push origin 1.0.4
```
7. Go to github and draft a new release
8. Select the tag, write a description, and publish
9. Double check packagist for updated version
g
