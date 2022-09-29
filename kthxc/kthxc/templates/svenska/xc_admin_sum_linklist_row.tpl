<!-- xc_admin_sum_linklist_row.tpl template (v. 2003-12-04) -->

<TR>
<TD><A href="{FILECALL}" style="font-weight: bold">{FILENAME}</A></TD>
<TD align=right>{TOTSUMS}</TD>
<TD align=right>{SHORTSUM}%</TD>
<TD align=right>{LONGSUM}%</TD>
<TD align=right>{MEANSUMLENGTH}%</TD>
<TD align=right>{PRECISION_F}%</TD>
<TD align=right>{PRECISION_ML}%</TD>
<TD align=center>{ABSTRACT}</TD>
<TD align=center>{CHANGED}</TD>
<TD>{ADDFIELD}</TD>
</TR>

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- FILECALL is the 'URL' to the file, actually it's a script call with parametres -->
<!-- FILENAME is the name of the file being called -->

<!-- Non-optional template markers *** Do NOT remove these! *** -->
<!-- ABSTRACT denotes if there are one or more abstracts available for a file -->
<!-- ADDFIELD is an additional field meant administrational file specific purposes, such as deleting rows in DB -->
<!-- CHANGED denotes if the file in question has been changed -->
<!-- LONGSUM is the length of the longest summary represented in the statistics for a file -->
<!-- MEANSUMLENGTH is the mean length of the summaries represented in the statistics for a file -->
<!-- SHORTSUM is the length of the shortest summary represented in the statistics for a file -->
<!-- TOTSUMS denotes the total number of summaries represented in the statistics for a file -->
